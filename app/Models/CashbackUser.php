<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbackUser extends Model
{
    protected $guarded = [];

    protected $casts = [
        'redeemed_at' => 'datetime',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
