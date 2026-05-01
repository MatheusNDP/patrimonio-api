@extends('layouts.app')

@section('content')
    <h1>Patrimônios</h1>

    <a href="/patrimonios/create" class="btn">
        Novo Patrimônio
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Data de Entrada</th>
                <th>Estabelecimento Pai</th>
                <th>Baixado</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($patrimonios as $patrimonio)
                <tr>
                    <td>{{ $patrimonio->id }}</td>
                    <td>{{ $patrimonio->nome }}</td>
                    <td>{{ $patrimonio->codigo }}</td>
                    <td>{{ $patrimonio->tipo }}</td>
                    <td>
                        {{ optional($patrimonio->data_entrada)->format('d/m/Y') }}
                    </td>
                    <td>
                        {{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}
                    </td>
                    <td>
                        {{ $patrimonio->baixado ? 'Sim' : 'Não' }}
                    </td>

                    <td>
                        <div class="actions">
                            <a href="/patrimonios/{{ $patrimonio->id }}" class="btn btn-secondary">
                                Ver
                            </a>

                            <a href="/patrimonios/{{ $patrimonio->id }}/edit" class="btn">
                                Editar
                            </a>

                            <form 
                                action="/patrimonios/{{ $patrimonio->id }}" 
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este patrimônio?')"
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
                    <td colspan="8">
                        Nenhum patrimônio cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection