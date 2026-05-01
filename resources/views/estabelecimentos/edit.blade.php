@extends('layouts.app')

@section('content')
    <h1>Editar Estabelecimento</h1>

    <form action="/estabelecimentos/{{ $estabelecimento->id }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome</label>
        <input 
            type="text" 
            name="nome" 
            id="nome" 
            value="{{ old('nome', $estabelecimento->nome) }}" 
            required
        >

        <label for="cnpj">CNPJ</label>
        <input 
            type="text" 
            name="cnpj" 
            id="cnpj" 
            value="{{ old('cnpj', $estabelecimento->cnpj) }}" 
            required
        >

        <label for="tipo">Tipo</label>
        <input 
            type="text" 
            name="tipo" 
            id="tipo" 
            value="{{ old('tipo', $estabelecimento->tipo) }}" 
            required
        >

        <label for="prazo_maximo_emprestimo">Prazo máximo de empréstimo em dias</label>
        <input 
            type="number" 
            name="prazo_maximo_emprestimo" 
            id="prazo_maximo_emprestimo" 
            value="{{ old('prazo_maximo_emprestimo', $estabelecimento->prazo_maximo_emprestimo) }}" 
            min="1"
        >

        <button type="submit" class="btn">
            Atualizar
        </button>

        <a href="/estabelecimentos" class="btn btn-secondary">
            Voltar
        </a>
    </form>
@endsection