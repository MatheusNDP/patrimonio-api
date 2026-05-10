<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmprestimoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estabelecimento_requerente_id' => [
                'required',
                'exists:estabelecimentos,id',
            ],

            'estabelecimento_atendente_id' => [
                'required',
                'exists:estabelecimentos,id',
                'different:estabelecimento_requerente_id',
            ],

            'patrimonios' => [
                'required',
                'array',
                'min:1',
            ],

            'patrimonios.*.patrimonio_id' => [
                'required',
                'exists:patrimonios,id',
            ],

            'patrimonios.*.data_emprestimo' => [
                'required',
                'date',
            ],

            'patrimonios.*.data_devolucao' => [
                'required',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'estabelecimento_requerente_id.required' => 'O estabelecimento requerente é obrigatório.',
            'estabelecimento_atendente_id.required' => 'O estabelecimento atendente é obrigatório.',
            'estabelecimento_atendente_id.different' => 'O estabelecimento requerente e o atendente devem ser diferentes.',

            'patrimonios.required' => 'Selecione ao menos um patrimônio.',
            'patrimonios.min' => 'Selecione ao menos um patrimônio.',

            'patrimonios.*.patrimonio_id.required' => 'O patrimônio é obrigatório.',
            'patrimonios.*.data_emprestimo.required' => 'A data de empréstimo do patrimônio é obrigatória.',
            'patrimonios.*.data_devolucao.required' => 'A data de devolução do patrimônio é obrigatória.',
        ];
    }
}