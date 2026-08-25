document.addEventListener('DOMContentLoaded', function() {
    
    let procedimentos = window.dadosProcedimentos || [];
    
    let selectProcedimento = document.getElementById('procedimento_id');
    let exibeTipo = document.getElementById('exibe-tipo');
    let resumoNome = document.getElementById('resumo-nome');
    let resumoDescricao = document.getElementById('resumo-descricao');
    let resumoPreco = document.getElementById('resumo-preco');

    if (selectProcedimento) {
        selectProcedimento.addEventListener('change', function() {
            let idSelecionado = this.value;
            
            let procedimento = procedimentos.find(p => p.procedimento_id == idSelecionado);

            if (procedimento) {
                if (procedimento.tipos) {
                    exibeTipo.style.display = 'block';
                    exibeTipo.innerHTML = `<strong>Tipo de Serviço:</strong> ${procedimento.tipos.nome}`;
                }

                resumoNome.innerHTML = `<strong>Serviço:</strong> ${procedimento.nome}`;
                
                resumoDescricao.style.display = 'block';
                resumoDescricao.innerHTML = `<strong>Descrição:</strong> ${procedimento.descricao}`;
                
                let precoFormatado = parseFloat(procedimento.preco).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
                resumoPreco.innerHTML = `<strong>Valor:</strong> ${precoFormatado}`;
            }
        });
    }
});