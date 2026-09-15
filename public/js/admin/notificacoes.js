document.addEventListener(
    'DOMContentLoaded',
    function () {

        const pesquisa =
            document.getElementById(
                'pesquisa-notificacoes'
            );

        const notificacoes =
            document.querySelectorAll(
                '.notificacao-item'
            );

        const vazio =
            document.getElementById(
                'nenhuma-notificacao-pesquisa'
            );


        function removerAcentos(texto) {

            return texto
                .normalize('NFD')
                .replace(
                    /[\u0300-\u036f]/g,
                    ''
                );

        }


        if (!pesquisa) {
            return;
        }


        pesquisa.addEventListener(
            'input',
            function () {

                const termo =
                    removerAcentos(
                        this.value
                    )
                    .toLowerCase()
                    .trim();


                let encontrados = 0;


                notificacoes.forEach(
                    function (notificacao) {

                        const texto =
                            removerAcentos(
                                notificacao.dataset.busca || ''
                            )
                            .toLowerCase();


                        const mostrar =
                            texto.includes(termo);


                        notificacao.style.display =
                            mostrar
                                ? 'flex'
                                : 'none';


                        if (mostrar) {
                            encontrados++;
                        }

                    }
                );


                if (vazio) {

                    vazio.style.display =
                        encontrados === 0
                            ? 'block'
                            : 'none';

                }

            }
        );

    }   
);