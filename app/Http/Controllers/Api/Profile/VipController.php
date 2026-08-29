<?php
namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Vip;
use App\Models\Wallet;
use App\Models\VipUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VipController extends Controller
{
    
    public function userRewards()
    {
        $user = auth()->user();

        $rewards = DB::table('user_rewards')
            ->join('games', function($join) {
                $join->on('games.id', '=', 'user_rewards.game_id')           
                     ->on('games.provider_id', '=', 'user_rewards.provider_id');
            })
            ->where('user_rewards.user_id', $user->id)
            ->orderBy('user_rewards.created_at', 'desc')
            ->select(
                'user_rewards.id',
                'user_rewards.reward_type',
                'user_rewards.rounds',
          		'user_rewards.reward_bonus',
                'user_rewards.created_at',
                'games.game_code',
                'games.provider_id',
                'games.id as game_id',
                'games.cover as image'
            )
            ->get();

        return response()->json($rewards);
    }



  	public function index()
    {
        $user = auth('api')->user();
        $wallet = $user->wallet;
        
        // Buscar o registro VIP do usuário
        $userVipRecord = VipUser::where('user_id', $user->id)
            ->orderBy('level', 'desc')
            ->first();

        $currentVipLevel = Vip::where('bet_level', $wallet->vip_level)->first();
        
        $nivelToday = Vip::whereNull('bet_period')->get();
        $nivelWeekly = Vip::where('bet_period', 'weekly')->get();
        $nivelMonthly = Vip::where('bet_period', 'monthly')->get();
        $nivelYearly = Vip::where('bet_period', 'yearly')->get();
        
        $nextVipLevel = Vip::where('bet_level', '>', $wallet->vip_level)
            ->orderBy('bet_level')
            ->first();

        return response()->json([
            'nivelToday' => $nivelToday,
            'nivelWeekly' => $nivelWeekly,
            'nivelMonthly' => $nivelMonthly,
            'nivelYearly' => $nivelYearly,
            'currentLevel' => $currentVipLevel,
            'nextLevel' => $nextVipLevel,
            'vipPoints' => $userVipRecord ? $userVipRecord->points : 0, // Usar pontos do registro VIP
            'pointsToNextLevel' => $nextVipLevel 
                ? $nextVipLevel->bet_required - ($userVipRecord ? $userVipRecord->points : 0)
                : 0
        ]);
    }
}