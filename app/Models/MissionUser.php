<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionUser extends Model
{
    use HasFactory;

    protected $table = 'mission_users';

    protected $fillable = [
        'user_id',
        'mission_id',
        'progress',
        'completed',
        'claimed',
        'completed_at',
        'claimed_at',
        'rounds',
        'rewards',
        'status',
    ];

    protected $casts = [
        'progress' => 'decimal:2',
        'completed' => 'boolean',
        'claimed' => 'boolean',
        'completed_at' => 'datetime',
        'claimed_at' => 'datetime',
        'rewards' => 'decimal:2',
    ];

    protected $appends = ['progress_percentage'];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentageAttribute()
    {
        // Aqui você pode definir uma meta fixa ou adaptar para algo dinâmico
        $target = 100; // exemplo: meta de 100

        if ($target == 0) {
            return 0;
        }

        $percentage = ($this->progress / $target) * 100;
        return min(100, round($percentage, 2));
    }
}
