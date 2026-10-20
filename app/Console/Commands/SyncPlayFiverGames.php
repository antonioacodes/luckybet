<?php
namespace App\Console\Commands;
use App\Models\Game;
use App\Models\GamesKey;
use App\Models\Provider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
class SyncPlayFiverGames extends Command
{
    protected $signature='playfiver:sync-games';
    protected $description='Sincroniza provedores e jogos PlayFivers v2';
    public function handle(): int
    {
        $keys=GamesKey::first();
        if (!$keys || !$keys->playfiver_token || !$keys->playfiver_secret) { $this->error('Configure as credenciais PlayFiver no painel.'); return self::FAILURE; }
        $base=rtrim($keys->playfiver_url ?: 'https://api.playfivers.com','/');
        $res=Http::acceptJson()->timeout(20)->get($base.'/api/v2/providers');
        if (!$res->successful() || (int)$res->json('status')!==1) { $this->error('Falha ao listar provedores PlayFivers.'); return self::FAILURE; }
        $count=0;
        foreach ($res->json('data',[]) as $remote) {
            $id=(string)($remote['id'] ?? ''); $name=trim((string)($remote['name'] ?? '')); if (!$id || !$name) continue;
            $provider=Provider::firstOrNew(['code'=>'playfiver:'.$id,'distribution'=>'playfiver']);
            $provider->fill(['name'=>$name,'status'=>(int)($remote['status'] ?? 1),'cover'=>$remote['image_url'] ?? null,'rtp'=>95]); $provider->save();
            $games=Http::acceptJson()->timeout(20)->get($base.'/api/v2/games',['provider'=>$id]);
            if (!$games->successful() || (int)$games->json('status')!==1) { $this->warn('Falha ao carregar '.$name); continue; }
            $homeGames = 0;
            foreach ($games->json('data',[]) as $item) {
                $remoteCode=trim((string)($item['game_code'] ?? '')); if (!$remoteCode) continue;

                // Keep PlayFiver's remote code in game_id for API launch requests.
                // game_code is the local route identifier and must not collide with
                // another provider's code (especially the legacy iGamingPlay catalog).
                $localCode='pf_'.$provider->id.'_'.substr(hash('sha256',$remoteCode),0,32);
                $game=Game::firstOrNew([
                    'provider_id'=>$provider->id,
                    'distribution'=>'playfiver',
                    'game_id'=>$remoteCode,
                ]);
                $isActive = (bool)($item['status'] ?? false);
                $showOnHome = $isActive && $homeGames < 8;
                $game->fill(['provider_id'=>$provider->id,'game_server_url'=>null,'game_id'=>$remoteCode,'game_name'=>$item['name'] ?? $remoteCode,'game_code'=>$localCode,'game_original'=>(bool)($item['original'] ?? false),'game_type'=>'slot','description'=>null,'cover'=>$item['image_url'] ?? '', 'status'=>$isActive,'technology'=>'html5','has_lobby'=>0,'is_mobile'=>1,'has_freespins'=>(bool)($item['rounds_free'] ?? false),'has_tables'=>0,'only_demo'=>0,'rtp'=>95,'distribution'=>'playfiver','views'=>0,'is_featured'=>false,'show_home'=>$showOnHome]); $game->save(); $count++; if ($showOnHome) $homeGames++;
            }
        }
        $this->info($count.' jogos sincronizados.'); return self::SUCCESS;
    }
}
