<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatrimonioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $patrimonio = $this->route('patrimonio');
        $patrimonioId = is_object($patrimonio) ? $patrimonio->id : $patrimonio;

        return [
            'nome' => ['required', 'string', 'max:255'],

            'codigo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('patrimonios', 'codigo')->ignore($patrimonioId),
            ],

            'tipo' => ['required', 'string', Rule::in(['Proprio', 'Alugado', 'Emprestado'])],

            'data_entrada' => ['required', 'date'],

            'estabelecimento_pai_id' => [
                'required',
                'integer',
                Rule::exists('estabelecimentos', 'id'),
            ],

            'baixado' => ['nullable', 'boolean'],

            'data_baixa' => ['nullable', 'required_if:baixado,true', 'date'],

            'motivo_baixa' => ['nullable', 'required_if:baixado,true', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do patrimônio é obrigatório.',
            'codigo.required' => 'O código do patrimônio é obrigatório.',
            'codigo.unique' => 'Este código já está cadastrado.',
            'tipo.required' => 'O tipo do patrimônio é obrigatório.',
            'tipo.in' => 'O tipo deve ser Proprio, Alugado ou Emprestado.',
            'data_entrada.required' => 'A data de entrada é obrigatória.',
            'estabelecimento_pai_id.required' => 'O estabelecimento pai é obrigatório.',
            'estabelecimento_pai_id.exists' => 'O estabelecimento informado não existe.',
            'data_baixa.required_if' => 'A data da baixa é obrigatória quando o patrimônio está baixado.',
            'motivo_baixa.required_if' => 'O motivo da baixa é obrigatório quando o patrimônio está baixado.',
        ];
    }
}