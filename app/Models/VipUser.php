<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VipUser extends Model
{
    protected $fillable = [
        'user_id',
        'vip_id',
        'level',
        'points',
        'status'
    ];

    public function checkAndUpdateLevel()
    {
        $nextLevel = Vip::where('bet_required', '<=', $this->points)
            ->orderBy('bet_required', 'desc')
            ->first();

        if ($nextLevel && $nextLevel->bet_level > $this->level) {
            $this->update([
                'level' => $nextLevel->bet_level
            ]);
        }

        return $this;
    }
}