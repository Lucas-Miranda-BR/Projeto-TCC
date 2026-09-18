document.addEventListener('DOMContentLoaded', function () {

    function mostrarToastDinamico(mensagem, tipo = 'success') {
        const divAlerta = document.createElement('div');
        divAlerta.className = `carrinho-alert ${tipo === 'erro' ? 'error' : 'success'}`;
        divAlerta.innerHTML = `<p><i class="bi bi-${tipo === 'erro' ? 'exclamation-triangle' : 'check-circle'}"></i> ${mensagem}</p>`;
        
        const header = document.querySelector('.carrinho-header');
        if (header) {
            header.insertAdjacentElement('afterend', divAlerta);
            setTimeout(() => {
                divAlerta.style.opacity = '0';
                setTimeout(() => divAlerta.remove(), 300);
            }, 5000);
        }
    }

    document.querySelectorAll('.carrinho-quantidade-form').forEach(function (form) {
        const input = form.querySelector('.quantidade-input');
        const botaoMenos = form.querySelector('.quantidade-menos');
        const botaoMais = form.querySelector('.quantidade-mais');
        const tokenCsrf = form.querySelector('input[name="_token"]').value;
        const url = form.action;

        if (!input || !botaoMenos || !botaoMais) return;

        function atualizarBotoesUI() {
            const quantidade = parseInt(input.value);
            botaoMenos.disabled = quantidade <= parseInt(input.min);
            botaoMais.disabled = quantidade >= parseInt(input.max);
        }

        function enviarAtualizacaoServidor(novaQuantidade) {
            botaoMenos.disabled = true;
            botaoMais.disabled = true;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': tokenCsrf,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantidade: novaQuantidade })
            })
            .then(response => response.json())
            .then(data => {
                if (data.removido) {
                    const itemCard = form.closest('.carrinho-item');
                    if(itemCard) itemCard.remove();
                    document.getElementById('valor-total-carrinho').innerText = 'R$ ' + data.novo_total;
                    mostrarToastDinamico(data.mensagem, 'erro');
                    
                    if(document.querySelectorAll('.carrinho-item').length === 0) {
                        window.location.reload();
                    }
                    return;
                }

                if (data.erro) {
                    input.value = data.estoque_atual;
                    atualizarBotoesUI();
                    mostrarToastDinamico(data.mensagem, 'erro');
                    return;
                }

                if (data.success) {
                    const itemId = url.split('/').pop();
                    const subtotalEl = document.getElementById('subtotal-' + itemId);
                    
                    if (subtotalEl) subtotalEl.innerText = 'R$ ' + data.novo_subtotal;
                    document.getElementById('valor-total-carrinho').innerText = 'R$ ' + data.novo_total;
                    atualizarBotoesUI();
                }
            })
            .catch(error => {
                console.error('Erro na requisição AJAX:', error);
                atualizarBotoesUI();
            });
        }

        botaoMenos.addEventListener('click', function () {
            let quantidade = parseInt(input.value);
            if (quantidade > parseInt(input.min)) {
                quantidade--;
                input.value = quantidade;
                enviarAtualizacaoServidor(quantidade);
            }
        });

        botaoMais.addEventListener('click', function () {
            let quantidade = parseInt(input.value);
            if (quantidade < parseInt(input.max)) {
                quantidade++;
                input.value = quantidade;
                enviarAtualizacaoServidor(quantidade);
            }
        });

        atualizarBotoesUI();
    });
});