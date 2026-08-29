<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_featured',
        'challenge_name',
        'challenge_description',
        'challenge_rules',
        'challenge_image',
        'challenge_type',
        'challenge_link',
        'challenge_start_date',
        'challenge_end_date',
        'challenge_bonus',
        'challenge_total',
        'challenge_currency',
        'challenge_provider',
        'challenge_gameid',
        'reward_type',
        'reward_freespins',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'challenge_start_date' => 'datetime',
        'challenge_end_date' => 'datetime',
        'challenge_bonus' => 'decimal:2',
    ];

    protected $appends = [
        'status',
        'time_to_start',
        'time_to_end',
        'is_active',
        'is_upcoming',
        'is_expired'
    ];

    // Relacionamento com usuários
    public function users()
    {
        return $this->belongsToMany(User::class, 'mission_users')
            ->withPivot('progress', 'completed', 'claimed', 'completed_at', 'claimed_at')
            ->withTimestamps();
    }


    // Progresso do usuário autenticado
    public function userProgress()
    {
        return $this->hasOne(MissionUser::class)
            ->where('user_id', auth('api')->id());
    }

    // Status da missão
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        
        if ($now->lt($this->challenge_start_date)) {
            return 'upcoming'; // Ainda não começou
        }
        
        if ($now->between($this->challenge_start_date, $this->challenge_end_date)) {
            return 'active'; // Em andamento
        }
        
        return 'expired'; // Expirada
    }

    // Tempo para começar
    public function getTimeToStartAttribute()
    {
        if ($this->status !== 'upcoming') {
            return null;
        }

        return $this->formatTimeDifference(Carbon::now(), $this->challenge_start_date);
    }

    // Tempo para terminar
    public function getTimeToEndAttribute()
    {
        if ($this->status !== 'active') {
            return null;
        }

        return $this->formatTimeDifference(Carbon::now(), $this->challenge_end_date);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsUpcomingAttribute()
    {
        return $this->status === 'upcoming';
    }

    public function getIsExpiredAttribute()
    {
        return $this->status === 'expired';
    }

    // Formatar diferença de tempo
    private function formatTimeDifference($from, $to)
    {
        $diff = $from->diff($to);
        
        return [
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $from->diffInSeconds($to),
            'formatted' => sprintf(
                '%d dias, %02d:%02d:%02d',
                $diff->d,
                $diff->h,
                $diff->i,
                $diff->s
            )
        ];
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('challenge_start_date', '<=', $now)
            ->where('challenge_end_date', '>=', $now);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('challenge_start_date', '>', Carbon::now());
    }

    public function scopeNotExpired($query)
    {
        return $query->where('challenge_end_date', '>=', Carbon::now());
    }
}
