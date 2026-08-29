<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'user_id',
        'transaction_id',
        'amount',
        'payload',
        'attempts',
        'status',
        'error',
        'last_attempt',
        'completed_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'last_attempt' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction associated with the event.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}