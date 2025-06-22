<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public $timestamps = false;

    protected $fillable = ['nome', 'sigla'];

    /**
     * Retorna todos os estados brasileiros
     */
    public static function orderBy($field)
    {
        $estados = collect([
            (object)['nome' => 'Acre', 'sigla' => 'AC'],
            (object)['nome' => 'Alagoas', 'sigla' => 'AL'],
            (object)['nome' => 'Amapá', 'sigla' => 'AP'],
            (object)['nome' => 'Amazonas', 'sigla' => 'AM'],
            (object)['nome' => 'Bahia', 'sigla' => 'BA'],
            (object)['nome' => 'Ceará', 'sigla' => 'CE'],
            (object)['nome' => 'Distrito Federal', 'sigla' => 'DF'],
            (object)['nome' => 'Espírito Santo', 'sigla' => 'ES'],
            (object)['nome' => 'Goiás', 'sigla' => 'GO'],
            (object)['nome' => 'Maranhão', 'sigla' => 'MA'],
            (object)['nome' => 'Mato Grosso', 'sigla' => 'MT'],
            (object)['nome' => 'Mato Grosso do Sul', 'sigla' => 'MS'],
            (object)['nome' => 'Minas Gerais', 'sigla' => 'MG'],
            (object)['nome' => 'Pará', 'sigla' => 'PA'],
            (object)['nome' => 'Paraíba', 'sigla' => 'PB'],
            (object)['nome' => 'Paraná', 'sigla' => 'PR'],
            (object)['nome' => 'Pernambuco', 'sigla' => 'PE'],
            (object)['nome' => 'Piauí', 'sigla' => 'PI'],
            (object)['nome' => 'Rio de Janeiro', 'sigla' => 'RJ'],
            (object)['nome' => 'Rio Grande do Norte', 'sigla' => 'RN'],
            (object)['nome' => 'Rio Grande do Sul', 'sigla' => 'RS'],
            (object)['nome' => 'Rondônia', 'sigla' => 'RO'],
            (object)['nome' => 'Roraima', 'sigla' => 'RR'],
            (object)['nome' => 'Santa Catarina', 'sigla' => 'SC'],
            (object)['nome' => 'São Paulo', 'sigla' => 'SP'],
            (object)['nome' => 'Sergipe', 'sigla' => 'SE'],
            (object)['nome' => 'Tocantins', 'sigla' => 'TO'],
        ]);

        if ($field === 'nome') {
            return $estados->sortBy('nome');
        }

        return $estados;
    }

    public static function all()
    {
        return self::orderBy('nome');
    }
}
