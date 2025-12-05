<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'date_of_birth'];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
