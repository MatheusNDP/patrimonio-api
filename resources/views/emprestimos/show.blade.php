@extends('layouts.app')

@section('content')
    <h1>Detalhes do Empréstimo</h1>

    <p>
        <strong>ID:</strong>
        {{ $emprestimo->id }}
    </p>

    <p>
        <strong>Estabelecimento Requerente:</strong>
        {{ $emprestimo->estabelecimentoRequerente->nome ?? 'Não informado' }}
    </p>

    <p>
        <strong>CNPJ Requerente:</strong>
        {{ $emprestimo->estabelecimentoRequerente->cnpj ?? 'Não informado' }}
    </p>

    <p>
        <strong>Estabelecimento Atendente:</strong>
        {{ $emprestimo->estabelecimentoAtendente->nome ?? 'Não informado' }}
    </p>

    <p>
        <strong>CNPJ Atendente:</strong>
        {{ $emprestimo->estabelecimentoAtendente->cnpj ?? 'Não informado' }}
    </p>

    <h2>Patrimônios Emprestados</h2>

    <table>
        <thead>
            <tr>
                <th>Patrimônio</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Data de Empréstimo</th>
                <th>Data de Devolução</th>
                <th>Estabelecimento Pai</th>
            </tr>
        </thead>

        <tbody>
            @forelse($emprestimo->patrimonios as $patrimonio)
                <tr>
                    <td>{{ $patrimonio->nome }}</td>
                    <td>{{ $patrimonio->codigo }}</td>
                    <td>{{ $patrimonio->tipo }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($patrimonio->pivot->data_emprestimo)->format('d/m/Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($patrimonio->pivot->data_devolucao)->format('d/m/Y') }}
                    </td>
                    <td>{{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum patrimônio vinculado a este empréstimo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="form-actions">
        <a href="/emprestimos" class="btn btn-secondary">Voltar</a>
    </div>
@endsection