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

        <label class="section-label">Patrimônios do Estabelecimento Atendente</label>

        <div class="patrimonios-grid">
            @foreach($patrimonios as $patrimonio)
                <div
                    class="patrimonio-card"
                    data-estabelecimento="{{ $patrimonio->estabelecimento_pai_id }}"
                    style="display: none;"
                >
                    <label class="patrimonio-option">
                        <input
                            type="checkbox"
                            class="patrimonio-checkbox"
                            name="patrimonios[{{ $loop->index }}][patrimonio_id]"
                            value="{{ $patrimonio->id }}"
                        >

                        <div class="patrimonio-card-content">
                            <div class="patrimonio-card-top">
                                <strong>{{ $patrimonio->nome }}</strong>
                                <span class="badge">{{ $patrimonio->tipo }}</span>
                            </div>

                            <div class="patrimonio-card-info">
                                <p><strong>Código:</strong> {{ $patrimonio->codigo }}</p>
                                <p><strong>Estabelecimento Pai:</strong> {{ $patrimonio->estabelecimentoPai->nome ?? 'Não informado' }}</p>
                            </div>

                            <div class="datas-patrimonio" style="display: none;">
                                <label>Data de Empréstimo</label>
                                <input
                                    type="date"
                                    class="data-input"
                                    name="patrimonios[{{ $loop->index }}][data_emprestimo]"
                                    disabled
                                >

                                <label>Data de Devolução</label>
                                <input
                                    type="date"
                                    class="data-input"
                                    name="patrimonios[{{ $loop->index }}][data_devolucao]"
                                    disabled
                                >
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <div id="mensagem-sem-patrimonio" class="empty-box">
            Selecione um estabelecimento atendente para listar os patrimônios disponíveis.
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="/emprestimos" class="btn btn-secondary">Voltar</a>
        </div>
    </form>

    <script>
        const selectAtendente = document.getElementById('estabelecimento_atendente_id');
        const cards = document.querySelectorAll('.patrimonio-card');
        const mensagem = document.getElementById('mensagem-sem-patrimonio');

        function atualizarPatrimonios() {
            const estabelecimentoSelecionado = selectAtendente.value;
            let encontrou = false;

            cards.forEach(card => {
                const pertenceAoEstabelecimento = card.dataset.estabelecimento === estabelecimentoSelecionado;

                const checkbox = card.querySelector('.patrimonio-checkbox');
                const datas = card.querySelector('.datas-patrimonio');
                const inputsData = card.querySelectorAll('.data-input');

                if (pertenceAoEstabelecimento) {
                    card.style.display = 'block';
                    encontrou = true;
                } else {
                    card.style.display = 'none';
                    checkbox.checked = false;
                    datas.style.display = 'none';

                    inputsData.forEach(input => {
                        input.disabled = true;
                        input.required = false;
                        input.value = '';
                    });
                }
            });

            if (!estabelecimentoSelecionado) {
                mensagem.innerText = 'Selecione um estabelecimento atendente para listar os patrimônios disponíveis.';
                mensagem.style.display = 'block';
                return;
            }

            mensagem.innerText = 'Nenhum patrimônio disponível para este estabelecimento.';
            mensagem.style.display = encontrou ? 'none' : 'block';
        }

        cards.forEach(card => {
            const checkbox = card.querySelector('.patrimonio-checkbox');
            const datas = card.querySelector('.datas-patrimonio');
            const inputsData = card.querySelectorAll('.data-input');

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    datas.style.display = 'block';

                    inputsData.forEach(input => {
                        input.disabled = false;
                        input.required = true;
                    });
                } else {
                    datas.style.display = 'none';

                    inputsData.forEach(input => {
                        input.disabled = true;
                        input.required = false;
                        input.value = '';
                    });
                }
            });
        });

        selectAtendente.addEventListener('change', atualizarPatrimonios);

        atualizarPatrimonios();
    </script>
@endsection