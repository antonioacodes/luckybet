<?php

namespace App\Console\Commands;

use App\Models\GamesKey;
use App\Models\Provider;
use App\Models\Game;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncIgamingPlayProvidersGames extends Command
{
    protected $signature = 'sync:igamingplay-providers-games 
                            {--providerId=* : Sincronizar somente estes providerIds (opcional)}';

    protected $description = 'Sincroniza provedores e jogos da ScorpioPlay (iGamingPlay) com as tabelas providers e games';

    protected string $baseUrl;
    protected string $token;
    protected string $distribution = 'igamingplay';

    public function handle(): int
    {
        $this->loadCredentials();

        $this->info('Sincronizando provedores iGamingPlay...');

        $providerIdsFilter = $this->option('providerId'); // array

        // 1) Buscar lista de provedores
        $providers = $this->fetchProviders();

        if (empty($providers)) {
            $this->warn('Nenhum provedor retornado pela API.');
            return self::SUCCESS;
        }

        foreach ($providers as $prov) {
            // Se foi passado filtro de providerId, respeita
            if (!empty($providerIdsFilter) && !in_array($prov['providerId'], $providerIdsFilter)) {
                continue;
            }

            $providerModel = $this->syncSingleProvider($prov);

            // 2) Para cada provedor, buscar lista de jogos
            $this->syncGamesForProvider($providerModel, $prov['providerId']);
        }

        $this->info('Sincronização concluída com sucesso.');
        return self::SUCCESS;
    }

    protected function loadCredentials(): void
    {
        $setting      = GamesKey::firstOrFail();
        $this->token  = $setting->igamingplay_token;
        $this->baseUrl = rtrim(env('IGAMINGPLAY_BASE_URL', 'https://new-api.scorpioplay.com'), '/');
    }

    /**
     * Chama /v1/provider/list
     */
    protected function fetchProviders(): array
    {
        $url = $this->baseUrl . '/v1/provider/list';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept'        => 'application/json',
        ])->get($url);

        if (!$response->successful()) {
            $this->error('Falha ao buscar provedores: HTTP ' . $response->status());
            $this->line($response->body());
            return [];
        }

        $json = $response->json();

        if (!($json['success'] ?? false)) {
            $this->error('API retornou erro ao listar provedores: ' . ($json['message'] ?? 'sem mensagem'));
            return [];
        }

        return $json['data'] ?? [];
    }

    /**
     * Sincroniza um provider da API com a tabela providers.
     *
     * Regra:
     * - Se já existir provider com code = providerId e distribution = igamingplay:
     *   - Se name/cover/status mudaram -> atualiza.
     * - Senão, cria novo.
     */
    protected function syncSingleProvider(array $prov): Provider
    {
        $code     = (string) $prov['providerId'];
        $name     = $prov['providerName'] ?? ('Provider ' . $code);
        $logo     = $prov['logo'] ?? null;
        $status   = (int) ($prov['status'] ?? 1);

  
        /** @var Provider|null $existing */
        $existing = Provider::where('code', $code)
            ->where('distribution', $this->distribution)
            ->first();

        if ($existing) {
            $dirty = false;

            if ($existing->name !== $name) {
                $existing->name = $name;
                $dirty = true;
            }

            if ($existing->cover !== $logo) {
                $existing->cover = $logo;
                $dirty = true;
            }

            if ((int) $existing->status !== $status) {
                $existing->status = $status;
                $dirty = true;
            }

            if ($existing->distribution !== $this->distribution) {
                $existing->distribution = $this->distribution;
                $dirty = true;
            }

            if ($dirty) {
                $existing->save();
                $this->info("Provedor atualizado: [{$existing->id}] {$existing->name} (code={$existing->code})");
            } else {
                $this->line("Provedor sem mudanças: [{$existing->id}] {$existing->name}");
            }

            return $existing;
        }

        // Criar novo
        $provider = Provider::create([
            'cover'        => $logo,
            'code'         => $code,
            'name'         => $name,
            'status'       => $status,
            'rtp'          => 90, // padrão da sua tabela
            'views'        => 1,
            'distribution' => $this->distribution,
        ]);

        $this->info("Provedor criado: [{$provider->id}] {$provider->name} (code={$provider->code})");

        return $provider;
    }

    /**
     * Busca jogos de um provider e sincroniza com a tabela games.
     */
    protected function syncGamesForProvider(Provider $provider, int $providerIdFromApi): void
    {
        $this->info("Sincronizando jogos do provedor {$provider->name} (API providerId={$providerIdFromApi})...");

        $url = $this->baseUrl . '/v1/game/list/' . $providerIdFromApi;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept'        => 'application/json',
        ])->get($url);

        if (!$response->successful()) {
            $this->error("Falha ao buscar jogos do providerId {$providerIdFromApi}: HTTP " . $response->status());
            $this->line($response->body());
            return;
        }

        $json = $response->json();

        if (!($json['success'] ?? false)) {
            $this->error('API retornou erro ao listar jogos: ' . ($json['message'] ?? 'sem mensagem'));
            return;
        }

        $games = $json['data'] ?? [];

        foreach ($games as $g) {
            $this->syncSingleGame($provider, $g);
        }
    }

    /**
     * Sincroniza um jogo da API com a tabela games.
     *
     * Regras:
     * - Chave de busca: game_code = gameID, provider_id = provider->id, distribution = igamingplay
     * - Se existir: compara e atualiza se algo mudou (nome, cover, status, tipo, etc).
     * - Se não existir: cria.
     */
protected function syncSingleGame(Provider $provider, array $g): void
{
    $gameCode  = $g['gameID'] ?? null;
    if (!$gameCode) {
        \Log::warning('GAME SEM gameID', ['raw' => $g]);
        return;
    }

    $gameName  = $g['gameName'] ?? $gameCode;
    $gameImageRaw = $g['gameImage'] ?? null; // pode ser string ou array
    $gameTypeN = (int) ($g['gameType'] ?? 0);
    $inMaint   = (bool) ($g['inMaintenance'] ?? false);

    // LOG ESPECÍFICO DO SCSlot (já está aí, pode manter se quiser)
    if ($gameCode === 'SCSlot') {
        \Log::info('DEBUG_SC_SLOT_GAME', ['raw' => $g]);
    }

    // 🔹 Normalizar imagem (cover) para sempre ser string ou null
    $cover = null;

    if (is_string($gameImageRaw)) {
        // Caso simples: já vem uma URL
        $cover = $gameImageRaw;
    } elseif (is_array($gameImageRaw)) {
        // Tenta pegar na seguinte ordem de prioridade:
        $cover =
            $gameImageRaw['desktop']['gameCover']
            ?? $gameImageRaw['desktop']['hero']
            ?? $gameImageRaw['desktop']['landscapeTile']
            ?? $gameImageRaw['mobile']['squareTile']
            ?? $gameImageRaw['mobile']['icon']['medium']
            ?? $gameImageRaw['mobile']['icon']['small']
            ?? null;

        // Se por algum motivo ainda for array (bem improvável), força para null
        if (is_array($cover)) {
            $cover = null;
        }
    }

    // Tipo do jogo
    $gameTypeStr = match ($gameTypeN) {
        0 => 'slot',
        1 => 'live',
        default => 'other',
    };

    $status = $inMaint ? '0' : '1';

    /** @var Game|null $existing */
    $existing = Game::where('game_code', $gameCode)
        ->where('provider_id', $provider->id)
        ->where('distribution', $this->distribution)
        ->first();

    if ($existing) {
        $dirty = false;

        if ($existing->game_name !== $gameName) {
            $existing->game_name = $gameName;
            $dirty = true;
        }

        if ($cover !== null && $existing->cover !== $cover) {
            $existing->cover = $cover;
            $dirty = true;
        }

        if ($existing->game_type !== $gameTypeStr) {
            $existing->game_type = $gameTypeStr;
            $dirty = true;
        }

        if ($existing->status !== $status) {
            $existing->status = $status;
            $dirty = true;
        }

        if ($existing->distribution !== $this->distribution) {
            $existing->distribution = $this->distribution;
            $dirty = true;
        }

        if ($dirty) {
            $existing->save();
            $this->line("  Jogo atualizado: [{$existing->id}] {$existing->game_name} (code={$existing->game_code})");
        } else {
            $this->line("  Jogo sem mudanças: [{$existing->id}] {$existing->game_name}");
        }

        return;
    }

    // Criar novo game
    $game = Game::create([
        'provider_id'     => $provider->id,
        'game_server_url' => 'inativo',
        'game_id'         => $gameCode,
        'payout'          => 100000,
        'game_name'       => $gameName,
        'game_code'       => $gameCode,
        'game_type'       => $gameTypeStr,
        'description'     => null,
        'cover'           => $cover,   // 🔹 agora é SEMPRE string ou null
        'status'          => $status,
        'technology'      => 'html5',
        'has_lobby'       => 0,
        'is_mobile'       => 1,
        'has_freespins'   => 0,
        'has_tables'      => 0,
        'only_demo'       => 0,
        'rtp'             => 0,
        'distribution'    => $this->distribution,
        'views'           => 0,
        'is_featured'     => 0,
        'show_home'       => 1,
        'game_original'   => 0,
    ]);

    $this->line("  Jogo criado: [{$game->id}] {$game->game_name} (code={$game->game_code})");
}


}
