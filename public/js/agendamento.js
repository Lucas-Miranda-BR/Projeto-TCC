document.addEventListener('DOMContentLoaded', function() {

    var paginaAgendamento = document.querySelector('.agendamento-page');
    var procedimentos = [];

    if (paginaAgendamento && paginaAgendamento.dataset.procedimentos) {
        try {
            procedimentos = JSON.parse(paginaAgendamento.dataset.procedimentos);
        } catch (e) {
            procedimentos = [];
        }
    }

    var selectProcedimento = document.getElementById('procedimento_id');
    var exibeTipo = document.getElementById('exibe-tipo');
    var resumoNome = document.getElementById('resumo-nome');
    var resumoDescricao = document.getElementById('resumo-descricao');
    var resumoPreco = document.getElementById('resumo-preco');

    function atualizarResumo() {
        if (!selectProcedimento) return;

        var idSelecionado = selectProcedimento.value;
        var procedimento = procedimentos.find(function(p) {
            return String(p.procedimento_id) === String(idSelecionado);
        });

        if (procedimento) {
            if (procedimento.tipos && exibeTipo) {
                exibeTipo.innerHTML = '<strong>Tipo de Serviço:</strong> ' + procedimento.tipos.nome;
            }

            if (resumoNome) {
                resumoNome.innerHTML = '<strong>Serviço:</strong> ' + procedimento.nome;
            }

            if (resumoDescricao) {
                resumoDescricao.innerHTML = '<strong>Descrição:</strong> ' + procedimento.descricao;
            }

            if (resumoPreco) {
                var precoFormatado = parseFloat(procedimento.preco).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
                resumoPreco.innerHTML = '<strong>Valor:</strong> ' + precoFormatado;
            }
        }
    }

    if (selectProcedimento) {
        selectProcedimento.addEventListener('change', atualizarResumo);
        if (selectProcedimento.value) {
            atualizarResumo();
        }
    }

});