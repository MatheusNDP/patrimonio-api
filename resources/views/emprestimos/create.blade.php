@extends('layouts.app')

@section('content')
    <h1>Novo Empréstimo</h1>

    <form action="/emprestimos" method="POST">
        @csrf

        <label for="estabelecimento_requerente_id">Estabelecimento Requerente</label>
        <select name="estabelecimento_requerente_id" id="estabelecimento_requerente_id" required>
            <option value="">Selecione</option>

            @foreach($estabelecimentos as $estabelecimento)
                <option value="{{ $estabelecimento->id }}" {{ old('estabelecimento_requerente_id') == $estabelecimento->id ? 'selected' : '' }}>
                    {{ $estabelecimento->nome }} - {{ $estabelecimento->tipo }}
                </option>
            @endforeach
        </select>

        <label for="estabelecimento_atendente_id">Estabelecimento Atendente</label>
        <select name="estabelecimento_atendente_id" id="estabelecimento_atendente_id" required>
            <option value="">Selecione</option>

            @foreach($estabelecimentos as $estabelecimento)
                <option value="{{ $estabelecimento->id }}" {{ old('estabelecimento_atendente_id') == $estabelecimento->id ? 'selected' : '' }}>
                    {{ $estabelecimento->nome }} - {{ $estabelecimento->tipo }}
                </option>
            @endforeach
        </select>

        <label for="data_emprestimo">Data do Empréstimo</label>
        <input
            type="date"
            name="data_emprestimo"
            id="data_emprestimo"
            value="{{ old('data_emprestimo') }}"
            required
        >

        <label for="data_devolucao">Data de Devolução</label>
        <input
            type="date"
            name="data_devolucao"
            id="data_devolucao"
            value="{{ old('data_devolucao') }}"
            required
        >

        <label>Patrimônios</label>

        <div class="checkbox-list">
            @forelse($patrimonios as $patrimonio)
                <label class="checkbox-item">
                    <input
                        type="checkbox"
                        name="patrimonios[]"
                        value="{{ $patrimonio->id }}"
                        {{ in_array($patrimonio->id, old('patrimonios', [])) ? 'checked' : '' }}
                    >

                    {{ $patrimonio->nome }}
                    -
                    Código: {{ $patrimonio->codigo }}
                    -
                    Pai: {{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}
                </label>
            @empty
                <p>Nenhum patrimônio disponível para empréstimo.</p>
            @endforelse
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="/emprestimos" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
@endsection