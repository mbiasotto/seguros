<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Establishment extends Model
{
    protected $fillable = [
        'vendor_id',
        'category_id',
        'nome',
        'endereco',
        'numero',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'descricao',
        'ativo',
        'name',
        'cnpj',
        'cpf',
        'tipo_documento',
        'description',
        'address',
        'logo',
        'image',
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Relacionamento com a categoria
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento com o onboarding do estabelecimento
     */
    public function onboarding(): HasOne
    {
        return $this->hasOne(EstablishmentOnboarding::class);
    }

    /**
     * Relacionamento com QR codes
     */
    public function qrCodes(): BelongsToMany
    {
        return $this->belongsToMany(QrCode::class, 'establishment_qr_code')
                    ->withPivot('notes')
                    ->withTimestamps();
    }
}
