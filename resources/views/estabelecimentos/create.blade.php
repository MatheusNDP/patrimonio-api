@extends('layouts.app')

@section('content')
    <h1>Novo Estabelecimento</h1>

    <form action="/estabelecimentos" method="POST">
        @csrf

        <label for="nome">Nome</label>
        <input 
            type="text" 
            name="nome" 
            id="nome" 
            value="{{ old('nome') }}" 
            required
        >

        <label for="cnpj">CNPJ</label>
        <input 
            type="text" 
            name="cnpj" 
            id="cnpj" 
            value="{{ old('cnpj') }}" 
            placeholder="00.000.000/0001-00"
            required
        >

        <label for="tipo">Tipo</label>
        <input 
            type="text" 
            name="tipo" 
            id="tipo" 
            value="{{ old('tipo') }}" 
            placeholder="Ex: Hospital, Clínica, Escola"
            required
        >

        <label for="prazo_maximo_emprestimo">Prazo máximo de empréstimo em dias</label>
        <input 
            type="number" 
            name="prazo_maximo_emprestimo" 
            id="prazo_maximo_emprestimo" 
            value="{{ old('prazo_maximo_emprestimo') }}" 
            min="1"
        >

        <button type="submit" class="btn">
            Salvar
        </button>

        <a href="/estabelecimentos" class="btn btn-secondary">
            Voltar
        </a>
    </form>
@endsection