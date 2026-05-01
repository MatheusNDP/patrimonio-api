<?php

namespace App\Services;

use App\Models\Patrimonio;

class PatrimonioService
{
    public function listar()
    {
        return Patrimonio::with('estabelecimentoPai')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function buscar(int $id): Patrimonio
    {
        return Patrimonio::with('estabelecimentoPai')->findOrFail($id);
    }

    public function criar(array $dados): Patrimonio
    {
        return Patrimonio::create($dados);
    }

    public function atualizar(int $id, array $dados): Patrimonio
    {
        $patrimonio = $this->buscar($id);

        $patrimonio->update($dados);

        return $patrimonio;
    }

    public function deletar(int $id): void
    {
        $patrimonio = $this->buscar($id);

        $patrimonio->delete();
    }
}