<?php

namespace App\Http\Requests;

use App\Models\Estabelecimento;
use App\Rules\CnpjValido;
use Illuminate\Foundation\Http\FormRequest;

class StoreEstabelecimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cnpj' => ['required', 'string', 'size:14', new CnpjValido(), 'unique:estabelecimentos,cnpj'],
            'razao_social' => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:estabelecimentos,email'],
            'telefone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'bairro' => ['required', 'string', 'max:100'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'size:2'],
            'cep' => ['required', 'string', 'size:8'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'taxa_multiplic' => ['required', 'numeric', 'min:0', 'max:100'],
            'taxa_estabelecimento' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->taxa_multiplic && $this->taxa_estabelecimento) {
                $soma = $this->taxa_multiplic + $this->taxa_estabelecimento;
                if ($soma != 100) {
                    $validator->errors()->add('taxa_estabelecimento', 'A soma das taxas deve ser exatamente 100%.');
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove formatação do CNPJ
        if ($this->cnpj) {
            $this->merge([
                'cnpj' => preg_replace('/\D/', '', $this->cnpj)
            ]);
        }

        // Remove formatação do telefone
        if ($this->telefone) {
            $this->merge([
                'telefone' => preg_replace('/\D/', '', $this->telefone)
            ]);
        }

        // Remove formatação do CEP
        if ($this->cep) {
            $this->merge([
                'cep' => preg_replace('/\D/', '', $this->cep)
            ]);
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado no sistema.',
            'razao_social.required' => 'A razão social é obrigatória.',
            'nome_fantasia.required' => 'O nome fantasia é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
            'email.unique' => 'Este email já está cadastrado no sistema.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve ter 10 ou 11 dígitos.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
            'endereco.required' => 'O endereço é obrigatório.',
            'numero.required' => 'O número é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.size' => 'O estado deve ter exatamente 2 caracteres.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.in' => 'A categoria selecionada é inválida.',
            'taxa_multiplic.required' => 'A taxa Multiplic é obrigatória.',
            'taxa_multiplic.numeric' => 'A taxa Multiplic deve ser um número.',
            'taxa_multiplic.min' => 'A taxa Multiplic deve ser maior ou igual a 0.',
            'taxa_multiplic.max' => 'A taxa Multiplic deve ser menor ou igual a 100.',
            'taxa_estabelecimento.required' => 'A taxa do estabelecimento é obrigatória.',
            'taxa_estabelecimento.numeric' => 'A taxa do estabelecimento deve ser um número.',
            'taxa_estabelecimento.min' => 'A taxa do estabelecimento deve ser maior ou igual a 0.',
            'taxa_estabelecimento.max' => 'A taxa do estabelecimento deve ser menor ou igual a 100.',
        ];
    }
}
