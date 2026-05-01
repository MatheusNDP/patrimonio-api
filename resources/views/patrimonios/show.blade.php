@extends('layouts.app')

@section('content')
    <h1>Detalhes do Patrimônio</h1>

    <div class="card">
        <p><strong>ID:</strong> {{ $patrimonio->id }}</p>

        <p><strong>Nome:</strong> {{ $patrimonio->nome }}</p>

        <p><strong>Código:</strong> {{ $patrimonio->codigo }}</p>

        <p><strong>Tipo:</strong> {{ $patrimonio->tipo }}</p>

        <p>
            <strong>Data de Entrada:</strong>
            {{ $patrimonio->data_entrada ? \Carbon\Carbon::parse($patrimonio->data_entrada)->format('d/m/Y') : '-' }}
        </p>

        <p>
            <strong>Estabelecimento Pai:</strong>
            {{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}
        </p>

        <p>
            <strong>Baixado:</strong>
            {{ $patrimonio->baixado ? 'Sim' : 'Não' }}
        </p>

        @if($patrimonio->baixado)
            <p>
                <strong>Data da Baixa:</strong>
                {{ $patrimonio->data_baixa ? \Carbon\Carbon::parse($patrimonio->data_baixa)->format('d/m/Y') : '-' }}
            </p>

            <p>
                <strong>Motivo da Baixa:</strong>
                {{ $patrimonio->motivo_baixa ?? '-' }}
            </p>
        @endif
    </div>

    <div class="form-actions">
        <a href="/patrimonios/{{ $patrimonio->id }}/edit" class="btn btn-warning">Editar</a>
        <a href="/patrimonios" class="btn btn-secondary">Voltar</a>
    </div>
@endsection