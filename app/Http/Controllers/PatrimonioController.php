<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatrimonioRequest;
use App\Models\Estabelecimento;
use App\Models\Patrimonio;
use App\Services\PatrimonioService;
use Exception;

class PatrimonioController extends Controller
{
    protected PatrimonioService $service;

    public function __construct(PatrimonioService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $patrimonios = $this->service->listar();

        return view('patrimonios.index', compact('patrimonios'));
    }

    public function create()
    {
        $estabelecimentos = Estabelecimento::orderBy('nome')->get();

        return view('patrimonios.create', compact('estabelecimentos'));
    }

    public function store(StorePatrimonioRequest $request)
    {
        $this->service->criar($request->validated());

        return redirect()
            ->route('patrimonios.index')
            ->with('success', 'Patrimônio cadastrado com sucesso.');
    }

    public function show(Patrimonio $patrimonio)
    {
        $patrimonio->load('estabelecimentoPai');

        return view('patrimonios.show', compact('patrimonio'));
    }

    public function edit(Patrimonio $patrimonio)
    {
        $estabelecimentos = Estabelecimento::orderBy('nome')->get();

        return view('patrimonios.edit', compact('patrimonio', 'estabelecimentos'));
    }

    public function update(StorePatrimonioRequest $request, Patrimonio $patrimonio)
    {
        $this->service->atualizar($patrimonio->id, $request->validated());

        return redirect()
            ->route('patrimonios.index')
            ->with('success', 'Patrimônio atualizado com sucesso.');
    }

    public function destroy(Patrimonio $patrimonio)
    {
        try {
            $this->service->deletar($patrimonio->id);

            return redirect()
                ->route('patrimonios.index')
                ->with('success', 'Patrimônio excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()
                ->route('patrimonios.index')
                ->with('error', 'Não foi possível excluir o patrimônio. Ele pode estar vinculado a um empréstimo.');
        }
    }
}