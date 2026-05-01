@extends('layouts.app')

@section('content')
    <h1>Novo Patrimônio</h1>

    <form action="/patrimonios" method="POST">
        @csrf

        <label for="nome">Nome</label>
        <input
            type="text"
            name="nome"
            id="nome"
            value="{{ old('nome') }}"
            required
        >

        <label for="codigo">Código</label>
        <input
            type="text"
            name="codigo"
            id="codigo"
            value="{{ old('codigo') }}"
            required
        >

        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo" required>
            <option value="">Selecione</option>
            <option value="Proprio" {{ old('tipo') == 'Proprio' ? 'selected' : '' }}>
                Próprio
            </option>
            <option value="Alugado" {{ old('tipo') == 'Alugado' ? 'selected' : '' }}>
                Alugado
            </option>
            <option value="Emprestado" {{ old('tipo') == 'Emprestado' ? 'selected' : '' }}>
                Emprestado
            </option>
        </select>

        <label for="data_entrada">Data de Entrada</label>
        <input
            type="date"
            name="data_entrada"
            id="data_entrada"
            value="{{ old('data_entrada') }}"
            required
        >

        <label for="estabelecimento_pai_id">Estabelecimento Pai</label>
        <select name="estabelecimento_pai_id" id="estabelecimento_pai_id" required>
            <option value="">Selecione</option>

            @foreach($estabelecimentos as $estabelecimento)
                <option
                    value="{{ $estabelecimento->id }}"
                    {{ old('estabelecimento_pai_id') == $estabelecimento->id ? 'selected' : '' }}
                >
                    {{ $estabelecimento->nome }} - {{ $estabelecimento->tipo }}
                </option>
            @endforeach
        </select>

        <label for="baixado">Baixado?</label>
        <select name="baixado" id="baixado" required>
            <option value="0" {{ old('baixado') == '0' ? 'selected' : '' }}>
                Não
            </option>
            <option value="1" {{ old('baixado') == '1' ? 'selected' : '' }}>
                Sim
            </option>
        </select>

        <label for="data_baixa">Data da Baixa</label>
        <input
            type="date"
            name="data_baixa"
            id="data_baixa"
            value="{{ old('data_baixa') }}"
        >

        <label for="motivo_baixa">Motivo da Baixa</label>
        <textarea
            name="motivo_baixa"
            id="motivo_baixa"
            rows="4"
        >{{ old('motivo_baixa') }}</textarea>

        <button type="submit" class="btn">
            Salvar
        </button>

        <a href="/patrimonios" class="btn btn-secondary">
            Voltar
        </a>
    </form>
@endsection