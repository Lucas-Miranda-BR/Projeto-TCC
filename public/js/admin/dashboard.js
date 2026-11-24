
document.addEventListener('DOMContentLoaded', function () {

    let graficoFaturamento = null;

    // Configurações
    const COR_LINHA = '#2b78e4';
    const COR_AREA = 'rgba(43, 120, 228, 0.08)';

    const NOMES_PERIODO = {
        dia: 'Hoje (por hora)',
        semana: 'Últimos 7 dias',
        mes: 'Últimos 30 dias'
    };

    /* =========================
       UTILIDADES
    ========================= */

    function atualizarDataHora() {
        const elementoData = document.getElementById('dashboard-date');
        const elementoHora = document.getElementById('dashboard-time');
        const agora = new Date();

        if (elementoData) {
            const dias = [
                'Domingo', 'Segunda-feira', 'Terça-feira',
                'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'
            ];

            const meses = [
                'janeiro', 'fevereiro', 'março', 'abril',
                'maio', 'junho', 'julho', 'agosto',
                'setembro', 'outubro', 'novembro', 'dezembro'
            ];

            elementoData.textContent =
                `${dias[agora.getDay()]}, ${agora.getDate()} de ${meses[agora.getMonth()]}`;
        }

        if (elementoHora) {
            elementoHora.textContent = agora.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    function formatarMoeda(valor) {
        return Number(valor).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    function formatarComSinal(valor) {
        const numero = Number(valor);

        if (numero === 0) {
            return formatarMoeda(0);
        }

        return (numero > 0 ? '+' : '-') +
            formatarMoeda(Math.abs(numero));
    }

    function definirTexto(id, texto) {
        const elemento = document.getElementById(id);

        if (elemento) {
            elemento.textContent = texto;
        }

        return elemento;
    }

    function definirMoedaGrande(id, valor) {
        const elemento = document.getElementById(id);

        if (!elemento) return;

        const partes = formatarMoeda(valor).split(',');

        elemento.textContent = partes[0];

        if (partes[1]) {
            const centavos = document.createElement('span');

            centavos.className = 'dash-centavos';
            centavos.textContent = ',' + partes[1];

            elemento.appendChild(centavos);
        }
    }

    function unidadeDoPeriodo(periodo) {
        return periodo === 'dia'
            ? {
                singular: 'hora',
                plural: 'horas',
                coluna: 'Hora'
            }
            : {
                singular: 'dia',
                plural: 'dias',
                coluna: 'Data'
            };
    }

    /* =========================
       CÁLCULO DO RESUMO
    ========================= */

    function calcularResumo(dados) {
        const pontos = [];

        dados.labels.forEach(function (rotulo, indice) {
            const valor = dados.networths[indice];

            if (valor !== null && valor !== undefined) {
                pontos.push({
                    rotulo: rotulo,
                    valor: Number(valor),
                    indice: indice
                });
            }
        });

        const resumo = {
            pontos: pontos,
            total: Number(dados.networth_total) || 0,
            positivos: 0,
            negativos: 0,
            melhor: null,
            pior: null,
            media: 0
        };

        pontos.forEach(function (ponto) {

            if (ponto.valor > 0) {
                resumo.positivos++;
            }

            if (ponto.valor < 0) {
                resumo.negativos++;
            }

            if (!resumo.melhor || ponto.valor > resumo.melhor.valor) {
                resumo.melhor = ponto;
            }

            if (!resumo.pior || ponto.valor < resumo.pior.valor) {
                resumo.pior = ponto;
            }
        });

        resumo.media = pontos.length
            ? resumo.total / pontos.length
            : 0;

        return resumo;
    }

    /* =========================
       ATUALIZAÇÃO DOS CARDS
    ========================= */

    function atualizarCards(dados, resumo) {
        const periodo = dados.periodo_selecionado;
        const unidade = unidadeDoPeriodo(periodo);
        const totalPontos = resumo.pontos.length;

        // Sincronização dos seletores
        const seletorCard = document.getElementById('card-periodo-select');
        const seletorGrafico = document.getElementById('filtro-periodo');

        if (seletorCard) seletorCard.value = periodo;
        if (seletorGrafico) seletorGrafico.value = periodo;

        // Card principal
        definirMoedaGrande('dashboard-networth', resumo.total);

        const legendas = {
            dia: 'Ganhos - Custos (Hoje)',
            semana: 'Acumulado (7 dias)',
            mes: 'Acumulado (30 dias)'
        };

        definirTexto(
            'dashboard-networth-label',
            legendas[periodo] || ''
        );

        // Progresso positivo
        const percentual = totalPontos
            ? Math.round((resumo.positivos / totalPontos) * 100)
            : 0;

        definirTexto(
            'hero-progresso-texto',
            resumo.positivos + ' de ' +
            totalPontos + ' ' +
            unidade.plural + ' no positivo'
        );

        definirTexto('hero-percentual', percentual + '%');

        const barra = document.getElementById('hero-progresso');

        if (barra) {
            barra.style.width = percentual + '%';
        }

        // Rótulos
        definirTexto(
            'stat-melhor-rotulo',
            'Melhor ' + unidade.singular
        );

        definirTexto(
            'stat-media-rotulo',
            'Média por ' + unidade.singular
        );

        // Melhor resultado
        if (resumo.melhor) {
            definirTexto(
                'stat-melhor-valor',
                formatarMoeda(resumo.melhor.valor)
            );

            definirTexto(
                'stat-melhor-data',
                resumo.melhor.rotulo
            );

        } else {
            definirTexto('stat-melhor-valor', formatarMoeda(0));
            definirTexto('stat-melhor-data', 'Sem movimentação');
        }

        // Média
        definirTexto(
            'stat-media-valor',
            formatarMoeda(resumo.media)
        );

        definirTexto(
            'stat-media-legenda',
            periodo === 'dia'
                ? 'média das horas de hoje'
                : 'média dos ' +
                  (NOMES_PERIODO[periodo] || '').toLowerCase()
        );

        // Informações do gráfico
        definirTexto(
            'chart-periodo',
            NOMES_PERIODO[periodo] || ''
        );

        definirTexto(
            'chart-total',
            formatarMoeda(resumo.total)
        );
    }

    /* =========================
       DESTAQUE: ATENÇÃO AO CAIXA
    ========================= */

    function atualizarDestaque(dados, resumo) {
        const unidade = unidadeDoPeriodo(dados.periodo_selecionado);

        const caixa = document.getElementById('destaque-box');
        const chip = document.getElementById('destaque-chip');
        const icone = document.getElementById('destaque-icone');

        const temNegativo = resumo.pior && resumo.pior.valor < 0;

        if (caixa) {
            caixa.classList.toggle('dash-destaque-ok', !temNegativo);
        }

        if (chip) {
            chip.className = 'dash-chip ' +
                (temNegativo ? 'dash-chip-neg' : 'dash-chip-pos');
        }

        if (icone) {
            icone.innerHTML =
                '<i class="bi ' +
                (temNegativo
                    ? 'bi-arrow-down-right'
                    : 'bi-check2-circle') +
                '"></i>';
        }

        if (temNegativo) {

            definirTexto(
                'destaque-titulo',
                'Pior ' + unidade.singular + ' do período'
            );

            definirTexto('destaque-data', resumo.pior.rotulo);

            definirTexto(
                'destaque-valor',
                formatarMoeda(resumo.pior.valor)
            );

            definirTexto(
                'destaque-chip',
                'Custos acima dos ganhos'
            );

            definirTexto(
                'destaque-meta',
                resumo.negativos + ' ' +
                (resumo.negativos === 1
                    ? unidade.singular
                    : unidade.plural) +
                ' no negativo neste período.'
            );

        } else {

            definirTexto('destaque-titulo', 'Caixa saudável');

            definirTexto(
                'destaque-data',
                NOMES_PERIODO[dados.periodo_selecionado] || ''
            );

            definirTexto(
                'destaque-valor',
                formatarMoeda(resumo.total)
            );

            definirTexto(
                'destaque-chip',
                'Nenhum ' + unidade.singular + ' no negativo'
            );

            definirTexto(
                'destaque-meta',
                'Os ganhos cobriram os custos em todo o período.'
            );
        }
    }

    /* =========================
       TABELA DE MOVIMENTAÇÕES
    ========================= */

    function atualizarTabela(dados, resumo) {
        const corpo = document.getElementById('tabela-movimentacao');

        if (!corpo) return;

        const unidade = unidadeDoPeriodo(dados.periodo_selecionado);

        definirTexto('tabela-coluna-data', unidade.coluna);

        corpo.innerHTML = '';

        if (!resumo.pontos.length) {
            const linha = document.createElement('tr');
            const celula = document.createElement('td');

            celula.colSpan = 4;
            celula.className = 'dash-tabela-vazio';
            celula.textContent = 'Nenhuma movimentação no período.';

            linha.appendChild(celula);
            corpo.appendChild(linha);

            return;
        }

        // Mais recentes primeiro, máximo de 8 linhas
        const recentes = resumo.pontos.slice(-8).reverse();

        recentes.forEach(function (ponto) {

            const indiceOriginal = resumo.pontos.indexOf(ponto);
            const anterior = resumo.pontos[indiceOriginal - 1];

            const linha = document.createElement('tr');

            const classeValor =
                ponto.valor > 0
                    ? 'dash-positivo'
                    : (ponto.valor < 0 ? 'dash-negativo' : '');

            let rotuloStatus = 'Sem movimento';
            let classeStatus = 'dash-chip-neutro';

            if (ponto.valor > 0) {
                rotuloStatus = 'Positivo';
                classeStatus = 'dash-chip-pos';
            }

            if (ponto.valor < 0) {
                rotuloStatus = 'Negativo';
                classeStatus = 'dash-chip-neg';
            }

            // Data
            const tdData = document.createElement('td');

            const ponto1 = document.createElement('span');

            ponto1.className = 'dash-bolinha ' +
                (ponto.valor > 0
                    ? 'dash-bolinha-pos'
                    : (ponto.valor < 0 ? 'dash-bolinha-neg' : ''));

            tdData.appendChild(ponto1);
            tdData.appendChild(
                document.createTextNode(ponto.rotulo)
            );

            // Valor
            const tdValor = document.createElement('td');

            tdValor.className =
                'dash-tabela-valor ' + classeValor;

            tdValor.textContent = formatarMoeda(ponto.valor);

            // Variação
            const tdVariacao = document.createElement('td');

            if (anterior) {
                const diferenca = ponto.valor - anterior.valor;

                tdVariacao.textContent = formatarComSinal(diferenca);

                tdVariacao.className =
                    diferenca > 0
                        ? 'dash-positivo'
                        : (diferenca < 0 ? 'dash-negativo' : 'dash-mudo');

            } else {
                tdVariacao.textContent = '—';
                tdVariacao.className = 'dash-mudo';
            }

            // Status
            const tdStatus = document.createElement('td');
            const chip = document.createElement('span');

            chip.className = 'dash-chip ' + classeStatus;
            chip.textContent = rotuloStatus;

            tdStatus.appendChild(chip);

            // Montagem da linha
            linha.appendChild(tdData);
            linha.appendChild(tdValor);
            linha.appendChild(tdVariacao);
            linha.appendChild(tdStatus);

            corpo.appendChild(linha);
        });
    }

    /* =========================
       GRÁFICO DE FATURAMENTO
    ========================= */

    function criarGrafico(dados, resumo) {
        const canvas = document.getElementById('grafico-faturamento');

        if (!canvas || typeof Chart === 'undefined') return;

        if (graficoFaturamento) {
            graficoFaturamento.destroy();
        }

        const indiceMelhor = resumo.melhor
            ? resumo.melhor.indice
            : -1;

        graficoFaturamento = new Chart(canvas, {
            type: 'line',

            data: {
                labels: dados.labels,

                datasets: [
                    {
                        label: 'Networth (Líquido)',
                        data: dados.networths,

                        borderColor: COR_LINHA,
                        backgroundColor: COR_AREA,

                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        spanGaps: false,

                        pointRadius: function (contexto) {
                            return contexto.dataIndex === indiceMelhor
                                ? 6
                                : 3;
                        },

                        pointHoverRadius: 7,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: COR_LINHA,
                        pointBorderWidth: 2
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',

                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            boxHeight: 8,
                            color: '#626262',

                            font: {
                                family: 'Poppins',
                                size: 12
                            }
                        }
                    },

                    tooltip: {
                        backgroundColor: '#2b1a1e',
                        titleColor: '#ffffff',
                        bodyColor: '#f6dfe3',

                        padding: 12,
                        cornerRadius: 10,

                        titleFont: {
                            family: 'Poppins',
                            weight: '600'
                        },

                        bodyFont: {
                            family: 'Poppins'
                        },

                        callbacks: {
                            label: function (contexto) {
                                return contexto.dataset.label +
                                    ': ' +
                                    formatarMoeda(contexto.raw);
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {
                            color: '#f1e8e9'
                        },

                        ticks: {
                            color: '#777777',

                            font: {
                                family: 'Poppins',
                                size: 11
                            },

                            maxTicksLimit: 6,

                            callback: function (valor) {
                                return 'R$ ' +
                                    Number(valor).toLocaleString('pt-BR');
                            }
                        }
                    },

                    x: {
                        border: {
                            display: false
                        },

                        grid: {
                            display: false
                        },

                        ticks: {
                            color: '#777777',

                            font: {
                                family: 'Poppins',
                                size: 11
                            },

                            maxRotation: 0,
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    }
                }
            }
        });
    }

    /* =========================
       CARREGAMENTO DO DASHBOARD
    ========================= */

    async function carregarDashboard(periodo = 'semana') {

        try {
            const resposta = await fetch(
                `/admin/dashboard/dados?periodo=${encodeURIComponent(periodo)}`,
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            if (!resposta.ok) {
                throw new Error('Erro ao carregar dados do dashboard.');
            }

            const dados = await resposta.json();

            const resumo = calcularResumo(dados);

            atualizarCards(dados, resumo);
            atualizarDestaque(dados, resumo);
            atualizarTabela(dados, resumo);
            criarGrafico(dados, resumo);

        } catch (erro) {
            console.error('Erro no dashboard:', erro);
        }
    }

    /* =========================
       FILTROS DE PERÍODO
    ========================= */

    const filtroGrafico = document.getElementById('filtro-periodo');
    const filtroCard = document.getElementById('card-periodo-select');

    function handleFiltroChange(event) {
        const periodoEscolhido = event.target.value;

        if (filtroGrafico) {
            filtroGrafico.value = periodoEscolhido;
        }

        if (filtroCard) {
            filtroCard.value = periodoEscolhido;
        }

        carregarDashboard(periodoEscolhido);
    }

    if (filtroGrafico) {
        filtroGrafico.addEventListener('change', handleFiltroChange);
    }

    if (filtroCard) {
        filtroCard.addEventListener('change', handleFiltroChange);
    }

    /* =========================
       INICIALIZAÇÃO
    ========================= */

    atualizarDataHora();

    setInterval(atualizarDataHora, 1000);

    carregarDashboard(
        filtroCard
            ? filtroCard.value
            : (filtroGrafico ? filtroGrafico.value : 'semana')
    );

});
