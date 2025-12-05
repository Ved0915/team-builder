<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state', 'country'];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderBy('player_team.sort_order');
    }
}
