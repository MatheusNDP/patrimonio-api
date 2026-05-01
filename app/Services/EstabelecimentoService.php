<?php

namespace App\Services;

use App\Models\Estabelecimento;

class EstabelecimentoService
{
    public function listar()
    {
        return Estabelecimento::orderBy('id', 'desc')->get();
    }

    public function buscar(int $id): Estabelecimento
    {
        return Estabelecimento::findOrFail($id);
    }

    public function criar(array $dados): Estabelecimento
    {
        return Estabelecimento::create($dados);
    }

    public function atualizar(int $id, array $dados): Estabelecimento
    {
        $estabelecimento = $this->buscar($id);
        $estabelecimento->update($dados);

        return $estabelecimento;
    }

    public function deletar(int $id): void
    {
        $estabelecimento = $this->buscar($id);
        $estabelecimento->delete();
    }
}