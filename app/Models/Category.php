<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'nome',
    ];

    /**
     * Relacionamento com estabelecimentos
     */
    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }
}
