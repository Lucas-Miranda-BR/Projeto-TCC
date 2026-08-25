document.addEventListener('DOMContentLoaded', function () {

    atualizarDataHora();
    criarGraficoFaturamento();

    setInterval(atualizarDataHora, 1000);

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

    const elementoData = document.getElementById('dashboard-date');
    const elementoHora = document.getElementById('dashboard-time');

    if (elementoData) {

        const diaSemana = diasSemana[agora.getDay()];
        const dia = agora.getDate();
        const mes = meses[agora.getMonth()];

        elementoData.textContent =
            `${diaSemana}, ${dia} de ${mes}`;

    }

    if (elementoHora) {

        elementoHora.textContent =
            agora.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            });

    }

}


function criarGraficoFaturamento() {

    const canvas = document.getElementById('faturamentoChart');

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: [
                'Seg',
                'Ter',
                'Qua',
                'Qui',
                'Sex',
                'Sáb',
                'Dom'
            ],

            datasets: [
                {
                    label: 'Faturamento',

                    data: [
                        4000,
                        8500,
                        9500,
                        8700,
                        10000,
                        17500,
                        20500
                    ],

                    borderColor: '#8A3FFC',

                    borderWidth: 3,

                    tension: 0.45,

                    fill: false,

                    pointRadius: 0,

                    pointHoverRadius: 6,

                    pointHoverBackgroundColor: '#8A3FFC',

                    pointHoverBorderColor: '#ffffff',

                    pointHoverBorderWidth: 2
                }
            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false
            },

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    displayColors: false,

                    backgroundColor: '#ffffff',

                    titleColor: '#777777',

                    bodyColor: '#111111',

                    borderColor: '#cccccc',

                    borderWidth: 1,

                    padding: 10,

                    callbacks: {

                        label: function (context) {

                            return 'R$ ' +
                                context.raw.toLocaleString('pt-BR');

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {
                        display: false
                    },

                    border: {
                        display: false
                    },

                    ticks: {

                        color: '#555555',

                        font: {
                            size: 9
                        }

                    }

                },

                y: {

                    beginAtZero: true,

                    suggestedMax: 22000,

                    ticks: {

                        stepSize: 5000,

                        color: '#777777',

                        font: {
                            size: 8
                        },

                        callback: function (value) {

                            if (value === 0) {
                                return '0';
                            }

                            return value.toLocaleString('pt-BR') + ' R$';

                        }

                    },

                    grid: {

                        color: '#dddddd',

                        borderDash: [4, 4]

                    },

                    border: {
                        display: false
                    }

                }

            }

        }

    });

}