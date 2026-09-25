document.addEventListener('DOMContentLoaded', function () {

    const toast = document.querySelector('.toast-carrinho');

    if (toast) {

        const botaoFechar = toast.querySelector('.toast-close');

        function fecharToast() {
            toast.classList.add('toast-saindo');
            setTimeout(function () {
                toast.remove();
            }, 300);
        }

        if (botaoFechar) {
            botaoFechar.addEventListener('click', fecharToast);
        }

        setTimeout(function () {
            if (document.body.contains(toast)) {
                fecharToast();
            }
        }, 3500);

    }

    document.querySelectorAll('.produto-compra-form').forEach(function (form) {

        const input = form.querySelector('.quantidade-input');
        const botaoMenos = form.querySelector('.quantidade-menos');
        const botaoMais = form.querySelector('.quantidade-mais');

        if (!input || !botaoMenos || !botaoMais) {
            return;
        }

        function atualizarBotoes() {
            const quantidade = parseInt(input.value);
            const minimo = parseInt(input.min);
            const maximo = parseInt(input.max);

            botaoMenos.disabled = quantidade <= minimo;
            botaoMais.disabled = quantidade >= maximo;
        }

        botaoMais.addEventListener('click', function () {
            let quantidade = parseInt(input.value);
            const maximo = parseInt(input.max);

            if (quantidade < maximo) {
                quantidade++;
                input.value = quantidade;
            }
            atualizarBotoes();
        });

        botaoMenos.addEventListener('click', function () {
            let quantidade = parseInt(input.value);
            const minimo = parseInt(input.min);

            if (quantidade > minimo) {
                quantidade--;
                input.value = quantidade;
            }
            atualizarBotoes();
        });

        atualizarBotoes();

    });

});