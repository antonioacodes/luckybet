<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $table = 'user_rewards';

    protected $fillable = [
        'user_id',
        'reward_type',
        'rounds',
      	'game_id',
      	'provider_id',
        'reward_bonus',
    ];

    public $timestamps = false;

    protected $casts = [
        'rounds' => 'integer',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
