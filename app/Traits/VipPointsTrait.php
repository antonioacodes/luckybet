<?php
namespace App\Traits;

use App\Models\Wallet;

trait VipPointsTrait
{
    /**
     * Add VIP points after a successful bet
     * 
     * @param float $betAmount
     * @return void
     */
    protected function addVipPoints(float $betAmount)
    {
        $user = auth('api')->user();
        
        if ($user) {
            $wallet = Wallet::whereUserId($user->id)->first();
            
            if ($wallet) {
                $wallet->updateVipPoints($betAmount);
            }
        }
    }
}