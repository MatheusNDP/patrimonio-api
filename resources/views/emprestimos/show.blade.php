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

    <p>
        <strong>Data do Empréstimo:</strong>
        {{ optional($emprestimo->data_emprestimo)->format('d/m/Y') }}
    </p>

    <p>
        <strong>Data de Devolução:</strong>
        {{ optional($emprestimo->data_devolucao)->format('d/m/Y') }}
    </p>

    <h2>Patrimônios Emprestados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Estabelecimento Pai</th>
                <th>Baixado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($emprestimo->patrimonios as $patrimonio)
                <tr>
                    <td>{{ $patrimonio->id }}</td>
                    <td>{{ $patrimonio->nome }}</td>
                    <td>{{ $patrimonio->codigo }}</td>
                    <td>{{ $patrimonio->tipo }}</td>
                    <td>{{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}</td>
                    <td>{{ $patrimonio->baixado ? 'Sim' : 'Não' }}</td>
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