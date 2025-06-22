<?php

namespace App\Http\Requests;

use App\Rules\CpfValido;
use Illuminate\Foundation\Http\FormRequest;

class CadastroSiteRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'cpf' => ['required', 'string', 'size:11', new CpfValido(), 'unique:clientes,cpf'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
            'cep' => ['required', 'string', 'size:8'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:100'],
            'neighborhood' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'cpflCode' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6', 'max:8', 'regex:/^[0-9]+$/'],
            'acceptTerms' => ['required', 'accepted'],
        ];
    }



    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado no sistema.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex' => 'O telefone deve ter 10 ou 11 dígitos.',

            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',

            'address.required' => 'O endereço é obrigatório.',
            'address.max' => 'O endereço deve ter no máximo 255 caracteres.',

            'number.required' => 'O número é obrigatório.',
            'number.max' => 'O número deve ter no máximo 20 caracteres.',

            'complement.max' => 'O complemento deve ter no máximo 100 caracteres.',

            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.max' => 'O bairro deve ter no máximo 100 caracteres.',

            'city.required' => 'A cidade é obrigatória.',
            'city.max' => 'A cidade deve ter no máximo 100 caracteres.',

            'state.required' => 'O estado é obrigatório.',
            'state.size' => 'O estado deve ter exatamente 2 caracteres.',

            'cpflCode.required' => 'O código CPFL é obrigatório.',
            'cpflCode.max' => 'O código CPFL deve ter no máximo 50 caracteres.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 6 dígitos.',
            'password.max' => 'A senha deve ter no máximo 8 dígitos.',
            'password.regex' => 'A senha deve conter apenas números.',

            'acceptTerms.required' => 'Você deve aceitar os termos e condições.',
            'acceptTerms.accepted' => 'Você deve aceitar os termos e condições.',
        ];
    }
}
