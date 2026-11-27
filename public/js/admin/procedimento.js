document.addEventListener('DOMContentLoaded', function () {

    const selectTipo =
        document.getElementById('tipo_id');

    const statusColorivel =
        document.getElementById('status-colorivel');


    if (selectTipo && statusColorivel) {

        function atualizarStatusColorivel() {

            const opcaoSelecionada =
                selectTipo.selectedIndex >= 0
                    ? selectTipo.options[selectTipo.selectedIndex]
                    : null;


            if (!opcaoSelecionada || !opcaoSelecionada.value) {

                statusColorivel.style.display =
                    'none';

                statusColorivel.textContent =
                    '';

                return;

            }


            const valorColorivel = (
                opcaoSelecionada.getAttribute('data-colorivel') || ''
            ).toString().toLowerCase().trim();


            const isColorivel =
                ['1', 'true', 'on', 'yes'].includes(valorColorivel);


            statusColorivel.style.display =
                'block';


            if (isColorivel) {

                statusColorivel.textContent =
                    'Este tipo permite coloração.';

                statusColorivel.style.color =
                    '#28a745';

            } else {

                statusColorivel.textContent =
                    'Este tipo NÃO é colorível.';

                statusColorivel.style.color =
                    '#6c757d';

            }

        }


        selectTipo.addEventListener(
            'change',
            atualizarStatusColorivel
        );


        atualizarStatusColorivel();

    }



    const linhas =
        Array.from(
            document.querySelectorAll(
                '#procedimentos-tbody .procedimento-linha'
            )
        );


    const informacao =
        document.getElementById(
            'procedimentos-pagination-info'
        );


    const navegacao =
        document.getElementById(
            'procedimentos-pagination'
        );


    const numeros =
        document.getElementById(
            'procedimentos-pagination-numeros'
        );


    const anterior =
        document.getElementById(
            'procedimentos-anterior'
        );


    const proximo =
        document.getElementById(
            'procedimentos-proximo'
        );


    if (
        linhas.length === 0
        ||
        !informacao
        ||
        !navegacao
        ||
        !numeros
        ||
        !anterior
        ||
        !proximo
    ) {

        return;

    }


    const itensPorPagina =
        5;


    let paginaAtual =
        1;


    function totalPaginas() {

        return Math.ceil(
            linhas.length /
            itensPorPagina
        );

    }


    function atualizarInformacao(
        inicio,
        fim
    ) {

        const primeiro =
            inicio + 1;


        const ultimo =
            Math.min(
                fim,
                linhas.length
            );


        informacao.textContent =
            'Exibindo ' +
            primeiro +
            '-' +
            ultimo +
            ' de ' +
            linhas.length +
            ' procedimentos';

    }


    function criarNumeros() {

        numeros.innerHTML =
            '';


        const total =
            totalPaginas();


        for (
            let pagina = 1;
            pagina <= total;
            pagina++
        ) {

            const botao =
                document.createElement(
                    'button'
                );


            botao.type =
                'button';


            botao.className =
                'procedimentos-pagination-num';


            botao.textContent =
                pagina;


            if (
                pagina === paginaAtual
            ) {

                botao.classList.add(
                    'active'
                );

            }


            botao.addEventListener(
                'click',
                function () {

                    paginaAtual =
                        pagina;


                    renderizar();

                }
            );


            numeros.appendChild(
                botao
            );

        }

    }


    function renderizar() {

        const total =
            totalPaginas();


        if (paginaAtual < 1) {

            paginaAtual =
                1;

        }


        if (paginaAtual > total) {

            paginaAtual =
                total;

        }


        const inicio =
            (paginaAtual - 1)
            *
            itensPorPagina;


        const fim =
            inicio
            +
            itensPorPagina;


        linhas.forEach(
            function (linha, indice) {

                if (
                    indice >= inicio
                    &&
                    indice < fim
                ) {

                    linha.style.display =
                        '';

                } else {

                    linha.style.display =
                        'none';

                }

            }
        );


        atualizarInformacao(
            inicio,
            fim
        );


        criarNumeros();


        anterior.disabled =
            paginaAtual === 1;


        proximo.disabled =
            paginaAtual === total;


        if (total <= 1) {

            navegacao.style.display =
                'none';

        } else {

            navegacao.style.display =
                'flex';

        }

    }


    anterior.addEventListener(
        'click',
        function () {

            if (paginaAtual > 1) {

                paginaAtual--;

                renderizar();

            }

        }
    );


    proximo.addEventListener(
        'click',
        function () {

            if (
                paginaAtual <
                totalPaginas()
            ) {

                paginaAtual++;

                renderizar();

            }

        }
    );


    renderizar();

});