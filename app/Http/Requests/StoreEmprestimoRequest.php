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
            'estabelecimento_requerente_id' => 'required|exists:estabelecimentos,id',
            'estabelecimento_atendente_id' => 'required|exists:estabelecimentos,id|different:estabelecimento_requerente_id',
            'data_emprestimo' => 'required|date',
            'data_devolucao' => 'required|date|after_or_equal:data_emprestimo',
            'patrimonios' => 'required|array|min:1',
            'patrimonios.*' => 'required|exists:patrimonios,id',
        ];
    }

    public function messages(): array
    {
        return [
            'estabelecimento_requerente_id.required' => 'O estabelecimento requerente é obrigatório.',
            'estabelecimento_requerente_id.exists' => 'O estabelecimento requerente informado não existe.',
            'estabelecimento_atendente_id.required' => 'O estabelecimento atendente é obrigatório.',
            'estabelecimento_atendente_id.exists' => 'O estabelecimento atendente informado não existe.',
            'estabelecimento_atendente_id.different' => 'O estabelecimento requerente e atendente devem ser diferentes.',
            'data_emprestimo.required' => 'A data de empréstimo é obrigatória.',
            'data_devolucao.required' => 'A data de devolução é obrigatória.',
            'data_devolucao.after_or_equal' => 'A data de devolução deve ser igual ou posterior à data de empréstimo.',
            'patrimonios.required' => 'Informe ao menos um patrimônio.',
            'patrimonios.array' => 'Os patrimônios devem ser enviados em formato de lista.',
            'patrimonios.min' => 'Informe ao menos um patrimônio.',
            'patrimonios.*.exists' => 'Um dos patrimônios informados não existe.',
        ];
    }
}