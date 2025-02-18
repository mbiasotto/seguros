<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }
}
