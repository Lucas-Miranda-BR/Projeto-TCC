let faturamentoChart = null;


document.addEventListener('DOMContentLoaded', function () {

    atualizarDataHora();

    criarGraficoFaturamento();

    configurarFiltros();

    configurarCalendario();

    setInterval(
        atualizarDataHora,
        1000
    );

});


function atualizarDataHora() {

    const agora = new Date();

    const diasSemana = [
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


    const elementoData =
        document.getElementById(
            'dashboard-date'
        );

    const elementoHora =
        document.getElementById(
            'dashboard-time'
        );


    if (elementoData) {

        const diaSemana =
            diasSemana[agora.getDay()];

        const dia =
            agora.getDate();

        const mes =
            meses[agora.getMonth()];


        elementoData.textContent =
            `${diaSemana}, ${dia} de ${mes}`;

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


function criarGraficoFaturamento() {

    const canvas =
        document.getElementById(
            'faturamentoChart'
        );


    if (!canvas) {
        return;
    }


    const ctx =
        canvas.getContext('2d');


    const labels =
        window.dashboardGrafico
            ? window.dashboardGrafico.labels
            : [
                'Seg',
                'Ter',
                'Qua',
                'Qui',
                'Sex',
                'Sáb',
                'Dom'
            ];


    const valores =
        window.dashboardGrafico
            ? window.dashboardGrafico.valores
            : [
                4000,
                8500,
                9500,
                8700,
                10000,
                17500,
                20500
            ];


    faturamentoChart =
        new Chart(ctx, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [
                    {

                        label:
                            'Faturamento',

                        data:
                            valores,

                        borderColor:
                            '#8A3FFC',

                        borderWidth:
                            3,

                        tension:
                            0.45,

                        fill:
                            false,

                        pointRadius:
                            0,

                        pointHoverRadius:
                            6,

                        pointHoverBackgroundColor:
                            '#8A3FFC',

                        pointHoverBorderColor:
                            '#ffffff',

                        pointHoverBorderWidth:
                            2

                    }
                ]

            },


            options: {

                responsive:
                    true,

                maintainAspectRatio:
                    false,


                interaction: {

                    mode:
                        'index',

                    intersect:
                        false

                },


                plugins: {

                    legend: {

                        display:
                            false

                    },


                    tooltip: {

                        displayColors:
                            false,

                        backgroundColor:
                            '#ffffff',

                        titleColor:
                            '#777777',

                        bodyColor:
                            '#111111',

                        borderColor:
                            '#cccccc',

                        borderWidth:
                            1,

                        padding:
                            10,


                        callbacks: {

                            label:
                                function (context) {

                                    return formatarMoeda(
                                        context.raw
                                    );

                                }

                        }

                    }

                },


                scales: {

                    x: {

                        grid: {

                            display:
                                false

                        },

                        border: {

                            display:
                                false

                        },

                        ticks: {

                            color:
                                '#555555',

                            font: {

                                size:
                                    9

                            }

                        }

                    },


                    y: {

                        beginAtZero:
                            true,

                        ticks: {

                            color:
                                '#777777',

                            font: {

                                size:
                                    8

                            },

                            callback:
                                function (value) {

                                    if (value === 0) {
                                        return '0';
                                    }

                                    return value.toLocaleString(
                                        'pt-BR'
                                    ) + ' R$';

                                }

                        },

                        grid: {

                            color:
                                '#dddddd',

                            borderDash:
                                [4, 4]

                        },

                        border: {

                            display:
                                false

                        }

                    }

                }

            }

        });

}


function configurarFiltros() {

    const filtros =
        document.querySelectorAll(
            '.dashboard-filter'
        );


    filtros.forEach(
        function (filtro) {

            filtro.addEventListener(
                'change',
                function () {

                    atualizarDashboard(
                        this.value
                    );

                }
            );

        }
    );


    const graficoPeriodo =
        document.getElementById(
            'grafico-periodo'
        );


    if (graficoPeriodo) {

        graficoPeriodo.addEventListener(
            'change',
            function () {

                atualizarDashboard(
                    this.value
                );

            }
        );

    }

}


async function atualizarDashboard(periodo) {

    if (!window.dashboardUrl) {

        console.error(
            'A rota do dashboard não foi encontrada.'
        );

        return;

    }


    try {

        const resposta =
            await fetch(
                `${window.dashboardUrl}?periodo=${periodo}`,
                {
                    headers: {
                        'Accept':
                            'application/json'
                    }
                }
            );


        if (!resposta.ok) {

            throw new Error(
                'Erro ao carregar dashboard.'
            );

        }


        const dados =
            await resposta.json();


        atualizarCards(
            dados
        );


        atualizarGrafico(
            dados
        );


        sincronizarFiltros(
            periodo
        );


    } catch (erro) {

        console.error(
            'Erro:',
            erro
        );

    }

}


function atualizarCards(dados) {

    alterarTexto(
        'faturamento',
        formatarMoeda(
            dados.faturamento
        )
    );


    alterarTexto(
        'lucro',
        formatarMoeda(
            dados.lucro
        )
    );


    alterarTexto(
        'porcentagem-faturamento',
        dados.porcentagemFaturamento + '%'
    );


    alterarTexto(
        'porcentagem-lucro',
        dados.porcentagemLucro + '%'
    );

}


function atualizarGrafico(dados) {

    if (!faturamentoChart) {
        return;
    }


    if (!dados.grafico) {
        return;
    }


    faturamentoChart.data.labels =
        dados.grafico.labels;


    faturamentoChart
        .data
        .datasets[0]
        .data =
            dados.grafico.valores;


    faturamentoChart.update();

}


function sincronizarFiltros(periodo) {

    const filtros =
        document.querySelectorAll(
            '.dashboard-filter'
        );


    filtros.forEach(
        function (filtro) {

            filtro.value =
                periodo;

        }
    );


    const graficoPeriodo =
        document.getElementById(
            'grafico-periodo'
        );


    if (graficoPeriodo) {

        graficoPeriodo.value =
            periodo;

    }


    alterarTexto(
        'grafico-descricao',
        textoPeriodo(periodo)
    );

}


function textoPeriodo(periodo) {

    if (periodo === 'hoje') {

        return 'Hoje';

    }


    if (periodo === 'semana') {

        return 'Últimos 7 dias';

    }


    if (periodo === 'mes') {

        return 'Este mês';

    }


    return '';

}


function formatarMoeda(valor) {

    return Number(valor).toLocaleString(
        'pt-BR',
        {

            style:
                'currency',

            currency:
                'BRL'

        }
    );

}


function alterarTexto(id, valor) {

    const elemento =
        document.getElementById(
            id
        );


    if (elemento) {

        elemento.textContent =
            valor;

    }

}


function configurarCalendario() {

    const botao =
        document.getElementById(
            'calendar-button'
        );


    const input =
        document.getElementById(
            'dashboard-calendar'
        );


    const texto =
        document.getElementById(
            'selected-date'
        );


    if (!input) {
        return;
    }


    const hoje =
        new Date();


    const ano =
        hoje.getFullYear();


    const mes =
        String(
            hoje.getMonth() + 1
        ).padStart(
            2,
            '0'
        );


    const dia =
        String(
            hoje.getDate()
        ).padStart(
            2,
            '0'
        );


    input.value =
        `${ano}-${mes}-${dia}`;


    if (texto) {

        texto.textContent =
            formatarDataInput(
                input.value
            );

    }


    if (botao) {

        botao.addEventListener(
            'click',
            function () {

                if (
                    typeof input.showPicker ===
                    'function'
                ) {

                    input.showPicker();

                } else {

                    input.click();

                }

            }
        );

    }


    input.addEventListener(
        'change',
        function () {

            if (!this.value) {
                return;
            }


            if (texto) {

                texto.textContent =
                    formatarDataInput(
                        this.value
                    );

            }

        }
    );

}


function formatarDataInput(data) {

    const partes =
        data.split('-');


    if (partes.length !== 3) {

        return data;

    }


    return (
        partes[2] +
        '/' +
        partes[1] +
        '/' +
        partes[0]
    );

}