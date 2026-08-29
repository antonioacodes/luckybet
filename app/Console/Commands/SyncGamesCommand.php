<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GamesKey;
use App\Models\Game;
use App\Models\Provider;

class SyncGamesCommand extends Command
{
    protected $signature   = 'games:sync';
    protected $description = 'Busca todos os provedores e jogos da API iGamingPlay e insere/atualiza no banco local';

    public function handle()
    {
        $keys = GamesKey::first();

        if (!$keys || !$keys->igamingplay_token) {
            $this->error('🔑 Token iGamingPlay não encontrado. Configure na tabela games_keys.');
            return;
        }

        $baseUrl = rtrim(env('IGAMINGPLAY_BASE_URL', 'https://sc4-api-en.dreamgates.net'), '/');
        $headers = [
            'Authorization' => 'Bearer '.$keys->igamingplay_token,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];

        //----------------------------------------------------------------------
        // 1️⃣ BUSCA PROVEDORES
        //----------------------------------------------------------------------
        $this->info('🔍 Buscando provedores...');
        $providersResponse = Http::withHeaders($headers)
            ->post("{$baseUrl}/v4/game/providers", ['lang' => 6]);

        if ($providersResponse->failed()) {
            $this->error('❌ Falha ao buscar provedores - '.$providersResponse->body());
            return;
        }

        $providersBody = $providersResponse->json();
        $providers     = $providersBody['data'] ?? [];

        $this->info("✅ ".count($providers)." provedores encontrados.");

        //----------------------------------------------------------------------
        // 2️⃣ INSERE/ATUALIZA PROVEDORES NO BANCO
        //----------------------------------------------------------------------
        foreach ($providers as $p) {
            Provider::updateOrCreate(
                ['id' => $p['provider_id']],
                [
                    'code'          => strtoupper(str_replace(' ', '_', $p['provider_name'] ?? '')),
                    'name'          => $p['locale_name'] ?? $p['provider_name'] ?? null,
                    'status'        => (int)($p['status'] ?? 1),
                    'cover'         => null,
                    'rtp'           => 90,
                    'views'         => 1,
                    'distribution'  => 'igamingplay',
                ]
            );
        }

        $this->info('📦 Provedores inseridos/atualizados com sucesso.');

        //----------------------------------------------------------------------
        // 3️⃣ LOOP DE PROVEDORES → BUSCA JOGOS DE CADA UM
        //----------------------------------------------------------------------
        foreach ($providers as $provider) {
            $providerId   = $provider['provider_id'];
            $providerName = $provider['provider_name'] ?? 'Sem nome';

            $this->info("🎮 Buscando jogos de {$providerName} (ID {$providerId})...");

            $gamesResponse = Http::withHeaders($headers)
                ->post("{$baseUrl}/v4/game/games", [
                    'provider_id' => $providerId,
                    'lang'        => 6,
                ]);

            if ($gamesResponse->failed()) {
                $this->error("❌ Falha ao buscar jogos de {$providerName} - ".$gamesResponse->body());
                continue;
            }

            $gamesBody = $gamesResponse->json();
            $gamesData = $gamesBody['data'] ?? [];
            $this->info("👉  ".count($gamesData)." jogos encontrados.");

            foreach ($gamesData as $gameData) {
                Game::updateOrCreate(
                    [
                        'provider_id' => $providerId,
                        'game_code'   => $gameData['game_code'],
                    ],
                    [
                        'game_id'           => $gameData['game_code'],
                        'game_name'         => $gameData['locale_name'] ?? $gameData['game_name'],
                        'cover'             => $gameData['game_image'] ?? null,
                        'game_server_url'   => $baseUrl,
                        'description'       => $gameData['category'] ?? null,
                        'game_type'         => $gameData['category'] ?? null,
                        'status'            => !empty($gameData['launch_enable']) ? 1 : 0,
                        'technology'        => 'html5',
                        'distribution'      => 'igamingplay',
                        'has_lobby'         => 0,
                        'has_freespins'     => 0,
                        'is_mobile'         => 1,
                        'only_demo'         => 0,
                        'rtp'               => 0,
                        'views'             => 0,
                        'is_featured'       => 0,
                        'show_home'         => 1,
                        'game_original'     => 0,
                    ]
                );
            }

            $this->info("✅ Finalizado {$providerName} com ".count($gamesData)." jogos inseridos/atualizados.");
        }

        //----------------------------------------------------------------------
        // 4️⃣ FINALIZAÇÃO
        //----------------------------------------------------------------------
        $this->info('🎯 Sincronização concluída com sucesso!');
    }
}
