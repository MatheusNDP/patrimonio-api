@extends('layouts.app')

@section('content')
    <h1>Empréstimos</h1>

    <div class="top-actions">
        <a href="/emprestimos/create" class="btn btn-primary">Novo Empréstimo</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Requerente</th>
                <th>Atendente</th>
                <th>Quantidade de Patrimônios</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($emprestimos as $emprestimo)
                <tr>
                    <td>{{ $emprestimo->id }}</td>
                    <td>{{ $emprestimo->estabelecimentoRequerente->nome ?? 'Não informado' }}</td>
                    <td>{{ $emprestimo->estabelecimentoAtendente->nome ?? 'Não informado' }}</td>
                    <td>{{ $emprestimo->patrimonios->count() }}</td>
                    <td>
                        <div class="actions">
                            <a href="/emprestimos/{{ $emprestimo->id }}" class="btn btn-secondary">
                                Ver
                            </a>

                            <form
                                action="/emprestimos/{{ $emprestimo->id }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente excluir este empréstimo?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum empréstimo cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection