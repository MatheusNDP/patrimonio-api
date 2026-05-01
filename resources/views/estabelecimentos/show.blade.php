@extends('layouts.app')

@section('content')
    <h1>Detalhes do Estabelecimento</h1>

    <p>
        <strong>ID:</strong>
        {{ $estabelecimento->id }}
    </p>

    <p>
        <strong>Nome:</strong>
        {{ $estabelecimento->nome }}
    </p>

    <p>
        <strong>CNPJ:</strong>
        {{ $estabelecimento->cnpj }}
    </p>

    <p>
        <strong>Tipo:</strong>
        {{ $estabelecimento->tipo }}
    </p>

    <p>
        <strong>Prazo máximo de empréstimo:</strong>
        {{ $estabelecimento->prazo_maximo_emprestimo ?? 'Sem prazo definido' }}
    </p>

    <div class="actions">
        <a href="/estabelecimentos" class="btn btn-secondary">
            Voltar
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
@endsection