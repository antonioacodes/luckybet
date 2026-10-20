<?php

namespace App\Models;

use App\Helpers\Core as Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Provider extends Model
{
    use HasFactory, HasEagerLimit;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'rtp',
        'status',
        'distribution',
        'cover',
        'views',
    ];

    /**
     * Fivers Game
     * @return HasMany
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'provider_id', 'id')
            ->orderBy('views', 'desc')
            ->where('show_home', 1)
            ->where('status', 1);
    }

    public function featuredGames(): HasMany
    {
        return $this->hasMany(Game::class, 'provider_id', 'id')
            ->orderBy('views', 'desc')
            ->where('is_featured', 1)
            ->where('status', 1);
    }

}
