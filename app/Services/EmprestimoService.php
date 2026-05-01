<?php

namespace App\Services;

use App\Models\Emprestimo;
use App\Models\Estabelecimento;
use App\Models\Patrimonio;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class EmprestimoService
{
    public function listar()
    {
        return Emprestimo::with([
            'estabelecimentoRequerente',
            'estabelecimentoAtendente',
            'patrimonios'
        ])
        ->orderBy('id', 'desc')
        ->get();
    }

    public function buscar(int $id): Emprestimo
    {
        return Emprestimo::with([
            'estabelecimentoRequerente',
            'estabelecimentoAtendente',
            'patrimonios'
        ])->findOrFail($id);
    }

    public function criar(array $dados): Emprestimo
    {
        return DB::transaction(function () use ($dados) {
            $requerente = Estabelecimento::findOrFail($dados['estabelecimento_requerente_id']);
            $atendente = Estabelecimento::findOrFail($dados['estabelecimento_atendente_id']);

            $this->validarMesmoTipo($requerente, $atendente);
            $this->validarPrazoMaximo($atendente, $dados['data_emprestimo'], $dados['data_devolucao']);
            $this->validarPatrimonios($dados['patrimonios'], $atendente->id);

            $emprestimo = Emprestimo::create([
                'estabelecimento_requerente_id' => $requerente->id,
                'estabelecimento_atendente_id' => $atendente->id,
                'data_emprestimo' => $dados['data_emprestimo'],
                'data_devolucao' => $dados['data_devolucao'],
            ]);

            $emprestimo->patrimonios()->attach($dados['patrimonios']);

            return $this->buscar($emprestimo->id);
        });
    }

    public function deletar(int $id): void
    {
        $emprestimo = Emprestimo::findOrFail($id);
        $emprestimo->delete();
    }

    private function validarMesmoTipo(Estabelecimento $requerente, Estabelecimento $atendente): void
    {
        if ($requerente->tipo !== $atendente->tipo) {
            throw new Exception('O empréstimo só pode ser realizado entre estabelecimentos do mesmo tipo.');
        }
    }

    private function validarPrazoMaximo(Estabelecimento $atendente, string $dataEmprestimo, string $dataDevolucao): void
    {
        if (!$atendente->prazo_maximo_emprestimo) {
            return;
        }

        $inicio = Carbon::parse($dataEmprestimo);
        $fim = Carbon::parse($dataDevolucao);

        $dias = $inicio->diffInDays($fim);

        if ($dias > $atendente->prazo_maximo_emprestimo) {
            throw new Exception(
                'O prazo máximo de empréstimo para este estabelecimento é de ' .
                $atendente->prazo_maximo_emprestimo .
                ' dias.'
            );
        }
    }

    private function validarPatrimonios(array $patrimonioIds, int $estabelecimentoAtendenteId): void
    {
        $patrimonios = Patrimonio::whereIn('id', $patrimonioIds)->get();

        foreach ($patrimonios as $patrimonio) {
            if ($patrimonio->baixado) {
                throw new Exception('O patrimônio "' . $patrimonio->nome . '" está baixado e não pode ser emprestado.');
            }

            if ($patrimonio->estabelecimento_pai_id !== $estabelecimentoAtendenteId) {
                throw new Exception('O patrimônio "' . $patrimonio->nome . '" não pertence ao estabelecimento atendente.');
            }
        }
    }
}