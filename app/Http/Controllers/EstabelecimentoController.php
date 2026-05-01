<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\StoreEstabelecimentoRequest;
use App\Models\Estabelecimento;
use App\Services\EstabelecimentoService;

class EstabelecimentoController extends Controller
{
    protected EstabelecimentoService $service;

    public function __construct(EstabelecimentoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $estabelecimentos = $this->service->listar();

        return view('estabelecimentos.index', compact('estabelecimentos'));
    }

    public function create()
    {
        return view('estabelecimentos.create');
    }

    public function store(StoreEstabelecimentoRequest $request)
    {
        $this->service->criar($request->validated());

        return redirect()
            ->route('estabelecimentos.index')
            ->with('success', 'Estabelecimento cadastrado com sucesso.');
    }

    public function show(Estabelecimento $estabelecimento)
    {
        return view('estabelecimentos.show', compact('estabelecimento'));
    }

    public function edit(Estabelecimento $estabelecimento)
    {
        return view('estabelecimentos.edit', compact('estabelecimento'));
    }

    public function update(StoreEstabelecimentoRequest $request, Estabelecimento $estabelecimento)
    {
        $this->service->atualizar($estabelecimento->id, $request->validated());

        return redirect()
            ->route('estabelecimentos.index')
            ->with('success', 'Estabelecimento atualizado com sucesso.');
    }

  public function destroy(Estabelecimento $estabelecimento)
{
    try {
        $this->service->deletar($estabelecimento->id);

        return redirect()
            ->route('estabelecimentos.index')
            ->with('success', 'Estabelecimento excluído com sucesso.');
    } catch (Exception $e) {
        return redirect()
            ->route('estabelecimentos.index')
            ->with('error', 'Não foi possível excluir o estabelecimento. Ele pode estar vinculado a patrimônios ou empréstimos.');
    }
}
}