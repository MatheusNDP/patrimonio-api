<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstabelecimentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $estabelecimento = $this->route('estabelecimento');
        $estabelecimentoId = is_object($estabelecimento) ? $estabelecimento->id : $estabelecimento;

        return [
            'nome' => ['required', 'string', 'max:255'],

            'cnpj' => [
                'required',
                'string',
                'max:20',
                Rule::unique('estabelecimentos', 'cnpj')->ignore($estabelecimentoId),
            ],

            'tipo' => ['required', 'string', 'max:100'],

            'prazo_maximo_emprestimo' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do estabelecimento é obrigatório.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'tipo.required' => 'O tipo do estabelecimento é obrigatório.',
        ];
    }
}