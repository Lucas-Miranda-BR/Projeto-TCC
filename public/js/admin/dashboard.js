document.addEventListener(
    'DOMContentLoaded',
    function () {

        let graficoFaturamento = null;


        function atualizarDataHora() {

            const elementoData =
                document.getElementById(
                    'dashboard-date'
                );

            const elementoHora =
                document.getElementById(
                    'dashboard-time'
                );


            const agora =
                new Date();


            if (elementoData) {

                const dias = [
                    'Domingo',
                    'Segunda-feira',
                    'Terça-feira',
                    'Quarta-feira',
                    'Quinta-feira',
                    'Sexta-feira',
                    'Sábado'
                ];


                const meses = [
                    'janeiro',
                    'fevereiro',
                    'março',
                    'abril',
                    'maio',
                    'junho',
                    'julho',
                    'agosto',
                    'setembro',
                    'outubro',
                    'novembro',
                    'dezembro'
                ];


                elementoData.textContent =
                    dias[agora.getDay()] +
                    ', ' +
                    agora.getDate() +
                    ' de ' +
                    meses[agora.getMonth()];

            }


            if (elementoHora) {

                elementoHora.textContent =
                    agora.toLocaleTimeString(
                        'pt-BR',
                        {
                            hour: '2-digit',
                            minute: '2-digit'
                        }
                    );

            }

        }


        function formatarMoeda(valor) {

            return Number(valor)
                .toLocaleString(
                    'pt-BR',
                    {
                        style: 'currency',
                        currency: 'BRL'
                    }
                );

        }


        async function carregarDashboard() {

            try {

                const resposta =
                    await fetch(
                        '/admin/dashboard/dados',
                        {
                            headers: {
                                'Accept':
                                    'application/json'
                            }
                        }
                    );


                if (!resposta.ok) {

                    throw new Error(
                        'Erro ao carregar os dados do dashboard.'
                    );

                }


                const dados =
                    await resposta.json();


                atualizarCards(dados);

                criarGrafico(dados);

            } catch (erro) {

                console.error(
                    'Erro no dashboard:',
                    erro
                );

            }

        }


        function atualizarCards(dados) {

            const faturamento =
                document.getElementById(
                    'dashboard-faturamento'
                );

            const servicos =
                document.getElementById(
                    'dashboard-servicos'
                );


            if (faturamento) {

                faturamento.textContent =
                    formatarMoeda(
                        dados.faturamento_total
                    );

            }


            if (servicos) {

                servicos.textContent =
                    dados.servicos_concluidos;

            }

        }


        function criarGrafico(dados) {

            const canvas =
                document.getElementById(
                    'grafico-faturamento'
                );


            if (!canvas) {
                return;
            }


            if (graficoFaturamento) {

                graficoFaturamento.destroy();

            }


            graficoFaturamento =
                new Chart(
                    canvas,
                    {
                        type: 'line',

                        data: {

                            labels:
                                dados.labels,

                            datasets: [

                                {
                                    label:
                                        'Produtos vendidos',

                                    data:
                                        dados.produtos,

                                    borderColor:
                                        '#9d1228',

                                    backgroundColor:
                                        'rgba(157, 18, 40, 0.08)',

                                    borderWidth:
                                        3,

                                    tension:
                                        0.35,

                                    pointRadius:
                                        3,

                                    pointHoverRadius:
                                        5,

                                    fill:
                                        false
                                },


                                {
                                    label:
                                        'Serviços concluídos',

                                    data:
                                        dados.servicos,

                                    borderColor:
                                        '#7650a8',

                                    backgroundColor:
                                        'rgba(118, 80, 168, 0.08)',

                                    borderWidth:
                                        3,

                                    tension:
                                        0.35,

                                    pointRadius:
                                        3,

                                    pointHoverRadius:
                                        5,

                                    fill:
                                        false
                                }

                            ]

                        },


                        options: {

                            responsive:
                                true,

                            maintainAspectRatio:
                                false,


                            interaction: {

                                intersect:
                                    false,

                                mode:
                                    'index'

                            },


                            plugins: {

                                legend: {

                                    display:
                                        true,

                                    position:
                                        'top'

                                },


                                tooltip: {

                                    callbacks: {

                                        label:
                                            function (
                                                context
                                            ) {

                                                return (
                                                    context
                                                        .dataset
                                                        .label +
                                                    ': ' +
                                                    formatarMoeda(
                                                        context
                                                            .raw
                                                    )
                                                );

                                            }

                                    }

                                }

                            },


                            scales: {

                                y: {

                                    beginAtZero:
                                        true,

                                    ticks: {

                                        callback:
                                            function (
                                                valor
                                            ) {

                                                return (
                                                    'R$ ' +
                                                    Number(
                                                        valor
                                                    )
                                                        .toLocaleString(
                                                            'pt-BR'
                                                        )
                                                );

                                            }

                                    }

                                },


                                x: {

                                    grid: {

                                        display:
                                            false

                                    }

                                }

                            }

                        }

                    }
                );

        }


        atualizarDataHora();

        setInterval(
            atualizarDataHora,
            1000
        );


        carregarDashboard();

    }
);