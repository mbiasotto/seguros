<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    // Relacionamentos
    public function estabelecimentos()
    {
        return $this->hasMany(Estabelecimento::class);
    }

    // Métodos auxiliares
    public function isAtiva()
    {
        return $this->ativo;
    }

    public function isInativa()
    {
        return !$this->ativo;
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeInativas($query)
    {
        return $query->where('ativo', false);
    }

    // Accessor para contagem de estabelecimentos
    public function getEstabelecimentosCountAttribute()
    {
        return $this->estabelecimentos()->count();
    }
}
