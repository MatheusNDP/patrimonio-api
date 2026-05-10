<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmprestimoRequest;
use App\Models\Estabelecimento;
use App\Models\Emprestimo;
use App\Models\Patrimonio;
use App\Services\EmprestimoService;
use Exception;

class EmprestimoController extends Controller
{
    private EmprestimoService $service;

    public function __construct(EmprestimoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $emprestimos = $this->service->listar();

        return view('emprestimos.index', compact('emprestimos'));
    }

    public function create()
    {
        $estabelecimentos = Estabelecimento::orderBy('nome')->get();

        $patrimonios = Patrimonio::with('estabelecimentoPai')
            ->where('baixado', false)
            ->orderBy('nome')
            ->get();

        return view('emprestimos.create', compact('estabelecimentos', 'patrimonios'));
    }

    public function store(StoreEmprestimoRequest $request)
    {
        try {
            $this->service->criar($request->validated());

            return redirect()
                ->route('emprestimos.index')
                ->with('success', 'Empréstimo cadastrado com sucesso.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Emprestimo $emprestimo)
    {
        $emprestimo = $this->service->buscar($emprestimo->id);

        return view('emprestimos.show', compact('emprestimo'));
    }

    public function destroy(Emprestimo $emprestimo)
    {
        $this->service->deletar($emprestimo->id);

        return redirect()
            ->route('emprestimos.index')
            ->with('success', 'Empréstimo excluído com sucesso.');
    }
}