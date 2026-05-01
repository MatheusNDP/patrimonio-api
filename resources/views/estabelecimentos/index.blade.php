@extends('layouts.app')

@section('content')
    <h1>Estabelecimentos</h1>

    <a href="/estabelecimentos/create" class="btn">
        Novo Estabelecimento
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Tipo</th>
                <th>Prazo Máximo</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($estabelecimentos as $estabelecimento)
                <tr>
                    <td>{{ $estabelecimento->id }}</td>
                    <td>{{ $estabelecimento->nome }}</td>
                    <td>{{ $estabelecimento->cnpj }}</td>
                    <td>{{ $estabelecimento->tipo }}</td>
                    <td>
                        {{ $estabelecimento->prazo_maximo_emprestimo ?? 'Sem prazo' }}
                    </td>

                    <td>
                        <div class="actions">
                            <a href="/estabelecimentos/{{ $estabelecimento->id }}" class="btn btn-secondary">
                                Ver
                            </a>

                            <a href="/estabelecimentos/{{ $estabelecimento->id }}/edit" class="btn">
                                Editar
                            </a>

                            <form 
                                action="/estabelecimentos/{{ $estabelecimento->id }}" 
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este estabelecimento?')"
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
                    <td colspan="6">
                        Nenhum estabelecimento cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection