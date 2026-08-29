<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wallets';
    protected $appends = ['total_balance', 'total_balance_without_bonus'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
public function updateVipPoints(float $betAmount)
    {
        // Adiciona pontos VIP igual ao valor da aposta
        $this->vip_points += $betAmount;
        
        // Verifica e atualiza o nível VIP se necessário
        $this->checkAndUpdateVipLevel();
        
        $this->save();
    }

    /**
     * Verifica e atualiza o nível VIP baseado nos pontos acumulados
     * 
     * @return void
     */
protected function checkAndUpdateVipLevel()
{
    // Encontra o próximo nível VIP
    $vipLevels = Vip::orderBy('bet_required', 'asc')->get();
    
    foreach ($vipLevels as $vipLevel) {
        if ($this->vip_points >= $vipLevel->bet_required) {
            // Atualiza o nível VIP na wallet
            $this->vip_level = $vipLevel->bet_level;

            // Busca o registro de VIP user para este usuário
            $vipUser = VipUser::where('user_id', $this->user_id)
                ->orderBy('level', 'desc')
                ->first();

            if ($vipUser) {
                // Atualiza o registro existente
                $vipUser->update([
                    'vip_id' => $vipLevel->id,
                    'level' => $vipLevel->bet_level,
                    'points' => $this->vip_points,
                    'status' => 'active'
                ]);
            } else {
                // Se não existir, cria novo registro
                VipUser::create([
                    'user_id' => $this->user_id,
                    'vip_id' => $vipLevel->id,
                    'level' => $vipLevel->bet_level,
                    'points' => $this->vip_points,
                    'status' => 'active'
                ]);
            }
        }
    }
}
  	public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

        });

        static::updated(function ($model) {
            if(auth()->check() && auth()->user()->hasRole('admin')) {
                \Helper::CreateReport('Atualizou Saldo', 'O Admin '. auth()->user()->name . ' atualizou o saldo do usuário ID:' . $model->id .  ' no valor de R$ '. $model->balance. ' / Bônus R$ '. $model->balance_bonus. ' / Saque R$ '. $model->balance_withdrawal);
            }
        });

        static::deleted(function ($model) {

        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'symbol',
        'balance',
        'balance_withdrawal',
        'balance_deposit_rollover',
        'balance_bonus',
        'balance_bonus_rollover',
        'balance_cryptocurrency',
        'balance_demo',
        'refer_rewards',
        'total_bet',
        'total_won',
        'total_lose',
        'last_won',
        'last_lose',
        'hide_balance',
        'active',
        'vip_level',
        'vip_points',
    ];

    /**
     * Cover
     * @return int
     */
    public function getTotalBalanceAttribute()
    {
        return ($this->attributes['balance'] + $this->attributes['balance_bonus'] + $this->attributes['balance_withdrawal']);
    }

    /**
     * Cover
     * @return int
     */
    public function getTotalBalanceWithoutBonusAttribute()
    {
        return ($this->attributes['balance'] + $this->attributes['balance_withdrawal']);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
