document.addEventListener('DOMContentLoaded', function () {

    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function recalcularTelaImediatamente() {
        let totalGeral = 0;

        document.querySelectorAll('.carrinho-quantidade-form').forEach(function (form) {
            const itemId = form.dataset.id;
            const preco = parseFloat(form.dataset.preco) || 0;
            const input = form.querySelector('.quantidade-input');
            const quantidade = parseInt(input.value) || 1;

            const subtotal = preco * quantidade;
            totalGeral += subtotal;

            const subtotalEl = document.getElementById('subtotal-' + itemId);
            if (subtotalEl) {
                subtotalEl.innerText = 'R$ ' + formatarMoeda(subtotal);
            }
        });

        const resumoEl = document.getElementById('carrinho-resumo');
        const descontoPercentual = resumoEl ? (parseFloat(resumoEl.dataset.desconto) || 0) : 0;
        if (descontoPercentual > 0) {
            totalGeral = totalGeral - (totalGeral * (descontoPercentual / 100));
        }

        const totalEl = document.getElementById('valor-total-carrinho');
        if (totalEl) {
            totalEl.innerText = 'R$ ' + formatarMoeda(totalGeral);
        }
    }

    document.querySelectorAll('.carrinho-quantidade-form').forEach(function (form) {
        const input = form.querySelector('.quantidade-input');
        const botaoMenos = form.querySelector('.quantidade-menos');
        const botaoMais = form.querySelector('.quantidade-mais');
        const tokenCsrf = form.querySelector('input[name="_token"]').value;
        const url = form.action;
        const itemId = form.dataset.id;

        if (!input || !botaoMenos || !botaoMais) return;

        function atualizarBotoesUI() {
            const quantidade = parseInt(input.value);
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;
            botaoMenos.disabled = quantidade <= min;
            botaoMais.disabled = quantidade >= max;
        }

        function sincronizarComServidor(novaQuantidade) {
            const formData = new FormData();
            formData.append('_token', tokenCsrf);
            formData.append('quantidade', novaQuantidade);
            formData.append('ajax', '1');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.novo_subtotal) {
                    const subtotalEl = document.getElementById('subtotal-' + itemId);
                    if (subtotalEl) subtotalEl.innerText = 'R$ ' + data.novo_subtotal;
                }
                if (data.novo_total) {
                    const totalEl = document.getElementById('valor-total-carrinho');
                    if (totalEl) totalEl.innerText = 'R$ ' + data.novo_total;
                }
                if (data.erro && data.estoque_atual !== undefined) {
                    input.value = data.estoque_atual;
                    recalcularTelaImediatamente();
                    atualizarBotoesUI();
                }
            })
            .catch(error => {
                console.error('Erro ao sincronizar carrinho:', error);
            });
        }

        botaoMenos.addEventListener('click', function (e) {
            e.preventDefault();
            let quantidade = parseInt(input.value);
            const min = parseInt(input.min) || 1;

            if (quantidade > min) {
                quantidade--;
                input.value = quantidade;
                atualizarBotoesUI();
                recalcularTelaImediatamente();
                sincronizarComServidor(quantidade);
            }
        });

        botaoMais.addEventListener('click', function (e) {
            e.preventDefault();
            let quantidade = parseInt(input.value);
            const max = parseInt(input.max) || 999;

            if (quantidade < max) {
                quantidade++;
                input.value = quantidade;
                atualizarBotoesUI();
                recalcularTelaImediatamente();
                sincronizarComServidor(quantidade);
            }
        });

        atualizarBotoesUI();
    });
});