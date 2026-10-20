<?php
namespace App\\Console\\Commands;
use App\\Models\\Game;
use App\\Models\\GamesKey;
use App\\Models\\Provider;
use Illuminate\\Console\\Command;
use Illuminate\\Support\\Facades\\Http;
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
            foreach ($games->json('data',[]) as $item) {
                $code=trim((string)($item['game_code'] ?? '')); if (!$code) continue;
                $game=Game::where('game_code',$code)->first();
                if ($game && $game->distribution!=='playfiver') { $this->warn('Código já usado: '.$code); continue; }
                $game=$game ?: new Game();
                $game->fill(['provider_id'=>$provider->id,'game_server_url'=>null,'game_id'=>$code,'game_name'=>$item['name'] ?? $code,'game_code'=>$code,'game_original'=>(bool)($item['original'] ?? false),'game_type'=>'slot','description'=>null,'cover'=>$item['image_url'] ?? '', 'status'=>(bool)($item['status'] ?? false),'technology'=>'html5','has_lobby'=>0,'is_mobile'=>1,'has_freespins'=>(bool)($item['rounds_free'] ?? false),'has_tables'=>0,'only_demo'=>0,'rtp'=>95,'distribution'=>'playfiver','views'=>0,'is_featured'=>false,'show_home'=>false]); $game->save(); $count++;
            }
        }
        $this->info($count.' jogos sincronizados.'); return self::SUCCESS;
    }
}
