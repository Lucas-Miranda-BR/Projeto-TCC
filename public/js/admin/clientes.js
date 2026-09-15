document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('notificacao-modal');
    const form = document.getElementById('form-enviar-notificacao');

    const nomeCliente = document.getElementById(
        'nome-cliente-notificacao'
    );

    const tipoNotificacao = document.getElementById(
        'tipo-notificacao'
    );

    const titulo = document.getElementById(
        'titulo-notificacao'
    );

    const mensagem = document.getElementById(
        'mensagem-notificacao'
    );

    const contadorTitulo = document.getElementById(
        'contador-titulo'
    );

    const contadorMensagem = document.getElementById(
        'contador-notificacao'
    );

    const previewTitulo = document.getElementById(
        'preview-titulo'
    );

    const previewMensagem = document.getElementById(
        'preview-mensagem'
    );

    const previewIcone = document.getElementById(
        'preview-icone'
    );

    const botoesAbrir = document.querySelectorAll(
        '.abrir-modal-notificacao'
    );

    const fechar = document.getElementById(
        'fechar-modal-notificacao'
    );

    const voltar = document.getElementById(
        'voltar-modal-notificacao'
    );

    const pesquisa = document.getElementById(
        'pesquisa-clientes'
    );

    const linhas = document.querySelectorAll(
        '.cliente-linha'
    );

    const nenhumResultado = document.getElementById(
        'nenhum-resultado'
    );


    function atualizarIcone() {

        if (!previewIcone || !tipoNotificacao) {
            return;
        }

        const tipo = tipoNotificacao.value;


        if (tipo === 'promocao') {

            previewIcone.innerHTML =
                '<i class="bi bi-gift"></i>';

            return;
        }


        if (tipo === 'cancelamento') {

            previewIcone.innerHTML =
                '<i class="bi bi-calendar-x"></i>';

            return;
        }


        if (tipo === 'lembrete') {

            previewIcone.innerHTML =
                '<i class="bi bi-calendar-check"></i>';

            return;
        }


        if (tipo === 'aviso') {

            previewIcone.innerHTML =
                '<i class="bi bi-exclamation-circle"></i>';

            return;
        }


        previewIcone.innerHTML =
            '<i class="bi bi-bell"></i>';
    }


    function atualizarPreview() {

        if (
            !titulo ||
            !mensagem ||
            !previewTitulo ||
            !previewMensagem
        ) {
            return;
        }

        const valorTitulo =
            titulo.value.trim();

        const valorMensagem =
            mensagem.value.trim();


        previewTitulo.textContent =
            valorTitulo
                ? valorTitulo
                : 'Título da notificação';


        previewMensagem.textContent =
            valorMensagem
                ? valorMensagem
                : 'Sua mensagem aparecerá aqui.';


        if (contadorTitulo) {

            contadorTitulo.textContent =
                titulo.value.length + '/255';

        }


        if (contadorMensagem) {

            contadorMensagem.textContent =
                mensagem.value.length + '/255';

        }


        atualizarIcone();
    }


    function abrirModal(botao) {

        if (!modal || !form) {
            return;
        }


        form.action =
            botao.dataset.url;


        if (nomeCliente) {

            nomeCliente.textContent =
                botao.dataset.nome;

        }


        if (tipoNotificacao) {

            tipoNotificacao.value =
                'aviso';

        }


        if (titulo) {

            titulo.value =
                '';

        }


        if (mensagem) {

            mensagem.value =
                '';

        }


        atualizarPreview();


        modal.classList.add(
            'ativo'
        );


        document.body.classList.add(
            'modal-aberto'
        );


        setTimeout(
            function () {

                if (titulo) {

                    titulo.focus();

                }

            },
            150
        );
    }


    function fecharModal() {

        if (!modal) {
            return;
        }


        modal.classList.remove(
            'ativo'
        );


        document.body.classList.remove(
            'modal-aberto'
        );


        if (form) {

            form.action =
                '';

        }


        if (tipoNotificacao) {

            tipoNotificacao.value =
                'aviso';

        }


        if (titulo) {

            titulo.value =
                '';

        }


        if (mensagem) {

            mensagem.value =
                '';

        }


        atualizarPreview();
    }


    function removerAcentos(texto) {

        return texto
            .normalize('NFD')
            .replace(
                /[\u0300-\u036f]/g,
                ''
            );
    }


    botoesAbrir.forEach(
        function (botao) {

            botao.addEventListener(
                'click',
                function () {

                    abrirModal(this);

                }
            );

        }
    );


    if (tipoNotificacao) {

        tipoNotificacao.addEventListener(
            'change',
            atualizarPreview
        );

    }


    if (titulo) {

        titulo.addEventListener(
            'input',
            atualizarPreview
        );

    }


    if (mensagem) {

        mensagem.addEventListener(
            'input',
            atualizarPreview
        );

    }


    if (fechar) {

        fechar.addEventListener(
            'click',
            fecharModal
        );

    }


    if (voltar) {

        voltar.addEventListener(
            'click',
            fecharModal
        );

    }


    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    fecharModal();

                }

            }
        );

    }


    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains(
                    'ativo'
                )
            ) {

                fecharModal();

            }

        }
    );


    if (pesquisa) {

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


                linhas.forEach(
                    function (linha) {

                        const busca =
                            removerAcentos(
                                linha.dataset.busca || ''
                            )
                            .toLowerCase();


                        const mostrar =
                            busca.includes(
                                termo
                            );


                        linha.style.display =
                            mostrar
                                ? ''
                                : 'none';


                        if (mostrar) {

                            encontrados++;

                        }

                    }
                );


                if (nenhumResultado) {

                    nenhumResultado.style.display =
                        encontrados === 0
                            ? 'flex'
                            : 'none';

                }

            }
        );

    }


    atualizarPreview();

});