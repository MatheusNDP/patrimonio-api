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
            'patrimonios.estabelecimentoPai',
        ])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function buscar(int $id): Emprestimo
    {
        return Emprestimo::with([
            'estabelecimentoRequerente',
            'estabelecimentoAtendente',
            'patrimonios.estabelecimentoPai',
        ])->findOrFail($id);
    }

    public function criar(array $dados): Emprestimo
    {
        return DB::transaction(function () use ($dados) {
            $requerente = Estabelecimento::findOrFail($dados['estabelecimento_requerente_id']);
            $atendente = Estabelecimento::findOrFail($dados['estabelecimento_atendente_id']);

            $this->validarMesmoTipo($requerente, $atendente);

            $emprestimo = Emprestimo::create([
                'estabelecimento_requerente_id' => $requerente->id,
                'estabelecimento_atendente_id' => $atendente->id,
            ]);

            foreach ($dados['patrimonios'] as $item) {
                $patrimonio = Patrimonio::findOrFail($item['patrimonio_id']);

                $this->validarPatrimonioPertenceAoAtendente($patrimonio, $atendente->id);
                $this->validarPatrimonioNaoBaixado($patrimonio);
                $this->validarDatas($item['data_emprestimo'], $item['data_devolucao']);
                $this->validarPrazoMaximo($atendente, $item['data_emprestimo'], $item['data_devolucao']);

                $emprestimo->patrimonios()->attach($patrimonio->id, [
                    'data_emprestimo' => $item['data_emprestimo'],
                    'data_devolucao' => $item['data_devolucao'],
                ]);
            }

            return $this->buscar($emprestimo->id);
        });
    }

    public function deletar(int $id): void
    {
        $emprestimo = Emprestimo::findOrFail($id);

        $emprestimo->patrimonios()->detach();

        $emprestimo->delete();
    }

    private function validarMesmoTipo(Estabelecimento $requerente, Estabelecimento $atendente): void
    {
        if ($requerente->tipo !== $atendente->tipo) {
            throw new Exception('O empréstimo só pode ser realizado entre estabelecimentos do mesmo tipo.');
        }
    }

    private function validarPatrimonioNaoBaixado(Patrimonio $patrimonio): void
    {
        if ($patrimonio->baixado) {
            throw new Exception('O patrimônio "' . $patrimonio->nome . '" está baixado e não pode ser emprestado.');
        }
    }

    private function validarPatrimonioPertenceAoAtendente(Patrimonio $patrimonio, int $estabelecimentoAtendenteId): void
    {
        if ((int) $patrimonio->estabelecimento_pai_id !== (int) $estabelecimentoAtendenteId) {
            throw new Exception('O patrimônio "' . $patrimonio->nome . '" não pertence ao estabelecimento atendente.');
        }
    }

    private function validarDatas(string $dataEmprestimo, string $dataDevolucao): void
    {
        $inicio = Carbon::parse($dataEmprestimo);
        $fim = Carbon::parse($dataDevolucao);

        if ($fim->lt($inicio)) {
            throw new Exception('A data de devolução não pode ser anterior à data de empréstimo.');
        }
    }

    private function validarPrazoMaximo(
        Estabelecimento $atendente,
        string $dataEmprestimo,
        string $dataDevolucao
    ): void {
        if (!$atendente->prazo_maximo_emprestimo) {
            return;
        }

        $inicio = Carbon::parse($dataEmprestimo);
        $fim = Carbon::parse($dataDevolucao);

        $dias = $inicio->diffInDays($fim);

        if ($dias > $atendente->prazo_maximo_emprestimo) {
            throw new Exception(
                'O prazo máximo de empréstimo para o estabelecimento "' .
                $atendente->nome .
                '" é de ' .
                $atendente->prazo_maximo_emprestimo .
                ' dias.'
            );
        }
    }
}