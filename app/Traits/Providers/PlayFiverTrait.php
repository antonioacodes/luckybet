<?php
namespace App\Traits\Providers;

use App\Helpers\Core;
use App\Models\Game;
use App\Models\GamesKey;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait PlayFiverTrait
{
    private function playFiverKeys(): ?GamesKey
    {
        $keys = GamesKey::first();
        return $keys && $keys->playfiver_code && $keys->playfiver_token && $keys->playfiver_secret ? $keys : null;
    }
    private function playFiverUrl(?GamesKey $keys): string
    {
        return rtrim($keys?->playfiver_url ?: 'https://api.playfivers.com', '/');
    }
    private function launchGamePlayFiver(Game $game, User $user): JsonResponse
    {
        $keys = $this->playFiverKeys();
        $wallet = Wallet::where('user_id',$user->id)->first();
        if (!$keys) return response()->json(['error'=>'PlayFiver credentials are not configured'],503);
        if (!$wallet || !$game->provider) return response()->json(['error'=>'Game wallet or provider not found'],422);
        try {
            $response = Http::acceptJson()->timeout(15)->post($this->playFiverUrl($keys).'/api/v2/game_launch',[
                'agentToken'=>$keys->playfiver_token, 'secretKey'=>$keys->playfiver_secret,
                'user_code'=>'user_'.$user->id, 'game_code'=>(string)($game->game_id ?: $game->game_code),
                'provider'=>(string)($game->provider->name ?: $game->provider->code),
                'game_original'=>(bool)$game->game_original,
                'user_balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus), 'lang'=>'pt',
            ]);
        } catch (\Throwable $e) {
            Log::error('PlayFiver launch failed',['game_id'=>$game->id,'error'=>$e->getMessage()]);
            return response()->json(['error'=>'PlayFiver is temporarily unavailable'],502);
        }
        $data=$response->json() ?: [];
        if (!$response->successful() || !($data['status'] ?? false) || empty($data['launch_url'])) {
            return response()->json(['error'=>$data['msg'] ?? 'Unable to launch game'],422);
        }
        $game->increment('views');
        return response()->json(['game_url'=>$data['launch_url'],'game_code'=>$game->game_code]);
    }
    public function webhookPlayFiver(Request $request): JsonResponse
    {
        $type=strtoupper((string)$request->input('type'));
        $user=$this->resolvePlayFiverUser((string)$request->input('user_code'));
        if ($type==='BALANCE') {
            $wallet=$user ? Wallet::where('user_id',$user->id)->first() : null;
            return $wallet ? response()->json(['balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus),'msg'=>'SUCCESS']) : response()->json(['balance'=>0,'msg'=>'INVALID_USER'],404);
        }
        $keys=$this->playFiverKeys();
        if (!$keys || !hash_equals((string)$keys->playfiver_code,(string)$request->input('agent_code')) || !hash_equals((string)$keys->playfiver_secret,(string)$request->input('agent_secret'))) return response()->json(['balance'=>0,'msg'=>'UNAUTHORIZED'],401);
        if (!$user) return response()->json(['balance'=>0,'msg'=>'INVALID_USER'],404);
        $slot=(array)$request->input('slot',[]);
        $txn=trim((string)($slot['txn_id'] ?? ''));
        if (!$txn || !in_array($type,['WINBET','REFUND'],true)) return response()->json(['balance'=>0,'msg'=>'INVALID_REQUEST'],422);
        return DB::transaction(function() use($user,$slot,$txn,$type) {
            $wallet=Wallet::where('user_id',$user->id)->lockForUpdate()->first();
            if (!$wallet) return response()->json(['balance'=>0,'msg'=>'INVALID_USER'],404);
            $duplicate = $type === 'REFUND'
                ? Order::where('user_id', $user->id)->where('type', 'refund')->where('transaction_id', $txn)->exists()
                : Order::where('user_id', $user->id)->whereIn('transaction_id', [$txn . ':debit', $txn . ':credit'])->exists();
            if ($duplicate) return response()->json(['balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus),'msg'=>'SUCCESS']);
            $round=(string)($slot['round_id'] ?? '');
            if ($type==='REFUND') {
                $betOrder=Order::where('user_id',$user->id)->where('type','bet')->where('transaction_id',$txn.':debit')->where('refunded',0)->lockForUpdate()->first();
                if (!$betOrder) $betOrder=Order::where('user_id',$user->id)->where('type','bet')->where('round_id',$round)->where('refunded',0)->lockForUpdate()->first();
                if (!$betOrder) return response()->json(['balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus),'msg'=>'TRANSACTION_NOT_FOUND'],404);
                $amount=abs((float)$betOrder->amount); $wallet->balance_withdrawal+=$amount; $wallet->save(); $betOrder->refunded=1; $betOrder->save();
                Order::create(['user_id'=>$user->id,'transaction_id'=>$txn,'game'=>$slot['game_code'] ?? 'PlayFiver','game_uuid'=>$slot['game_code'] ?? '','type'=>'refund','type_money'=>'balance_withdrawal','amount'=>$amount,'providers'=>'playfiver','refunded'=>1,'status'=>1,'round_id'=>$round]);
            } else {
                $txnType = strtolower((string) ($slot['txn_type'] ?? 'debit_credit'));
                $isFreeRound = (bool) data_get($slot, 'free_rounds.enable', false);
                $bet = ($isFreeRound || in_array($txnType, ['credit', 'bonus'], true)) ? 0 : max(0, (float) ($slot['bet'] ?? 0));
                $win = $txnType === 'debit' ? 0 : max(0, (float) ($slot['win'] ?? 0));
                if ($bet>0) {
                    $typeMoney=Core::DiscountBalance($wallet,$bet);
                    if ($typeMoney==='no_balance') return response()->json(['balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus),'msg'=>'INSUFFICIENT_USER_FUNDS'],400);
                    Order::create(['user_id'=>$user->id,'transaction_id'=>$txn.':debit','game'=>$slot['game_code'] ?? 'PlayFiver','game_uuid'=>$slot['game_code'] ?? '','type'=>'bet','type_money'=>$typeMoney,'amount'=>$bet,'providers'=>'playfiver','status'=>1,'round_id'=>$round]);
                    Core::generateGameHistory($user->id, 'bet', 0, $bet, $typeMoney, $txn);
                }
                if ($win>0) {
                    $wallet->refresh(); $wallet->balance_withdrawal+=$win; $wallet->save();
                    Order::create(['user_id'=>$user->id,'transaction_id'=>$txn.':credit','game'=>$slot['game_code'] ?? 'PlayFiver','game_uuid'=>$slot['game_code'] ?? '','type'=>'win','type_money'=>'balance_withdrawal','amount'=>$win,'providers'=>'playfiver','status'=>1,'round_id'=>$round]);
                    Core::generateGameHistory($user->id, 'win', $win, 0, 'balance_withdrawal', $txn);
                }
            }
            $wallet->refresh();
            return response()->json(['balance'=>(float)($wallet->balance+$wallet->balance_withdrawal+$wallet->balance_bonus),'msg'=>'SUCCESS']);
        });
    }
    public function schedulePlayFiverFreeBonus(Request $request): JsonResponse
    {
        $admin=auth('api')->user();
        if (!$admin || !$admin->hasRole('admin')) return response()->json(['error'=>'Forbidden'],403);
        if (!(bool)Core::getSetting()?->free_rounds_enabled) return response()->json(['error'=>'Free rounds are disabled'],403);
        $data=$request->validate(['user_code'=>'required|string|max:191','game_code'=>'required|string|max:191','rounds'=>'required|integer|min:1|max:23']);
        $keys=$this->playFiverKeys();
        if (!$keys) return response()->json(['error'=>'PlayFiver credentials are not configured'],503);
        $response=Http::acceptJson()->timeout(15)->post($this->playFiverUrl($keys).'/api/v2/free_bonus',[
            'agent_token'=>$keys->playfiver_token,'secret_key'=>$keys->playfiver_secret,
            'user_code'=>$data['user_code'],'game_code'=>$data['game_code'],'rounds'=>(int)$data['rounds'],
        ]);
        return response()->json($response->json() ?: ['error'=>'Invalid PlayFiver response'],$response->status());
    }
    private function resolvePlayFiverUser(string $code): ?User
    {
        if (preg_match('/^user_(\d+)$/',$code,$m)) return User::find((int)$m[1]);
        return User::where('email',$code)->first();
    }
}
