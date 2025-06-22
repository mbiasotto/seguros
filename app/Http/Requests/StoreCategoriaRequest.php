<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
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
        $categoriaId = $this->route('categoria') ? $this->route('categoria')->id : null;

        return [
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $categoriaId,
            'descricao' => 'nullable|string|max:500',
            'ativo' => 'sometimes|boolean'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
            'nome.unique' => 'Já existe uma categoria com este nome.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição deve ter no máximo 500 caracteres.',
            'ativo.boolean' => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Se ativo não foi enviado, define como true (ativo por padrão)
        if (!$this->has('ativo')) {
            $this->merge(['ativo' => true]);
        }
    }
}
