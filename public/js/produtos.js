/*
 * produtos.js
 * Funcionalidades da página de produtos:
 * 1. Remove fundo liso das imagens quando possível.
 * 2. Ajusta o enquadramento de fotos retangulares compatíveis.
 * 3. Controla os dropdowns dos filtros.
 */

(function () {

    function iniciarQuandoDOMPronto(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback, { once: true });
        } else {
            callback();
        }
    }

    iniciarQuandoDOMPronto(function () {

        /*
         * REMOÇÃO DE FUNDO DAS IMAGENS
         * - Só age se a borda da foto for de uma cor só; caso contrário, deixa a foto como está.
         * - Apaga a cor "de fora para dentro", então detalhes internos da mesma cor (rótulo branco) ficam.
         * - Não altera o arquivo no servidor: o recorte é refeito a cada visita.
         */

        var TOL = 38;                      // distância de cor considerada "fundo"
        var TOL2 = TOL * TOL;
        var SUAVIZACAO = 1.5;              // transição suave na borda do recorte
        var MIN_BORDA = 0.8;               // % da borda que precisa ter a cor do fundo
        var MIN_REMOVIDO = 0.02;
        var MAX_REMOVIDO = 0.94;
        var MARGEM = 0.04;                 // folga em volta do produto depois de cortar
        var MAX_LADO = 700;                // lado maior usado no processamento (px)

        function mediana(v) {
            v.sort(function (a, b) {
                return a - b;
            });

            return v[v.length >> 1];
        }

        function limitar(v) {
            return v < 0 ? 0 : (v > 255 ? 255 : Math.round(v));
        }

        function carregada(img) {
            return new Promise(function (resolve) {
                if (img.complete && img.naturalWidth) {
                    return resolve(img);
                }

                img.addEventListener('load', function () {
                    resolve(img);
                }, { once: true });

                img.addEventListener('error', function () {
                    resolve(img);
                }, { once: true });
            });
        }

        function processar(img) {
            return new Promise(function (resolve) {
                try {
                    var nw = img.naturalWidth;
                    var nh = img.naturalHeight;

                    if (!nw || !nh) {
                        return resolve(false);
                    }

                    var escala = Math.min(1, MAX_LADO / Math.max(nw, nh));
                    var w = Math.round(nw * escala);
                    var h = Math.round(nh * escala);

                    if (w < 20 || h < 20) {
                        return resolve(false);
                    }

                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;

                    var ctx = canvas.getContext('2d', {
                        willReadFrequently: true
                    });

                    ctx.drawImage(img, 0, 0, w, h);

                    // Dá erro se a imagem for de outro domínio (cai no catch e mantém a original).
                    var dados = ctx.getImageData(0, 0, w, h);
                    var d = dados.data;

                    // Já é um PNG recortado: não mexe.
                    var cantos = [
                        0,
                        (w - 1) * 4,
                        (h - 1) * w * 4,
                        ((h - 1) * w + w - 1) * 4
                    ];

                    var transp = 0;

                    cantos.forEach(function (p) {
                        if (d[p + 3] < 30) {
                            transp++;
                        }
                    });

                    if (transp >= 2) {
                        return resolve(false);
                    }

                    // Pixels da borda da imagem.
                    var per = [];
                    var x, y;

                    for (x = 0; x < w; x++) {
                        per.push(x, (h - 1) * w + x);
                    }

                    for (y = 1; y < h - 1; y++) {
                        per.push(y * w, y * w + w - 1);
                    }

                    // Cor do fundo = mediana da borda.
                    var rs = [];
                    var gs = [];
                    var bs = [];

                    per.forEach(function (i) {
                        rs.push(d[i * 4]);
                        gs.push(d[i * 4 + 1]);
                        bs.push(d[i * 4 + 2]);
                    });

                    var br = mediana(rs);
                    var bg = mediana(gs);
                    var bb = mediana(bs);

                    function dist2(i) {
                        var p = i * 4;

                        var dr = d[p] - br;
                        var dg = d[p + 1] - bg;
                        var db = d[p + 2] - bb;

                        return dr * dr + dg * dg + db * db;
                    }

                    // A borda precisa ser (quase toda) dessa cor, ou não é fundo liso.
                    var limite = Math.pow(TOL * 1.2, 2);
                    var parecidos = 0;

                    per.forEach(function (i) {
                        if (dist2(i) <= limite) {
                            parecidos++;
                        }
                    });

                    if (parecidos / per.length < MIN_BORDA) {
                        return resolve(false);
                    }

                    // Flood fill a partir da borda: 1 = fundo, 2 = borda do produto.
                    var mascara = new Uint8Array(w * h);
                    var pilha = new Int32Array(w * h);
                    var topo = 0;
                    var cand = [];

                    per.forEach(function (i) {
                        if (mascara[i] === 0 && dist2(i) <= TOL2) {
                            mascara[i] = 1;
                            pilha[topo++] = i;
                        }
                    });

                    function visitar(n) {
                        if (mascara[n] !== 0) {
                            return;
                        }

                        if (dist2(n) <= TOL2) {
                            mascara[n] = 1;
                            pilha[topo++] = n;
                        } else {
                            mascara[n] = 2;
                            cand.push(n);
                        }
                    }

                    while (topo > 0) {
                        var i = pilha[--topo];

                        var cx = i % w;
                        var cy = (i - cx) / w;

                        if (cx + 1 < w) visitar(i + 1);
                        if (cx > 0) visitar(i - 1);
                        if (cy + 1 < h) visitar(i + w);
                        if (cy > 0) visitar(i - w);
                    }

                    var removidos = 0;

                    for (i = 0; i < mascara.length; i++) {
                        if (mascara[i] === 1) {
                            removidos++;
                        }
                    }

                    var proporcao = removidos / (w * h);

                    if (proporcao < MIN_REMOVIDO || proporcao > MAX_REMOVIDO) {
                        return resolve(false);
                    }

                    // Apaga o fundo.
                    for (i = 0; i < mascara.length; i++) {
                        if (mascara[i] === 1) {
                            d[i * 4 + 3] = 0;
                        }
                    }

                    // Suaviza a borda do recorte (e tira o "resto" do fundo misturado na cor).
                    cand.forEach(function (n) {
                        var a = (Math.sqrt(dist2(n)) - TOL) / (TOL * SUAVIZACAO);

                        if (a >= 1) return;
                        if (a < 0) a = 0;

                        var p = n * 4;

                        if (a > 0.05) {
                            d[p] = limitar((d[p] - (1 - a) * br) / a);
                            d[p + 1] = limitar((d[p + 1] - (1 - a) * bg) / a);
                            d[p + 2] = limitar((d[p + 2] - (1 - a) * bb) / a);
                        }

                        d[p + 3] = Math.round(255 * a);
                    });

                    // Corta as sobras transparentes.
                    var minX = w;
                    var maxX = -1;
                    var minY = h;
                    var maxY = -1;

                    for (y = 0; y < h; y++) {
                        for (x = 0; x < w; x++) {
                            if (mascara[y * w + x] !== 1) {
                                if (x < minX) minX = x;
                                if (x > maxX) maxX = x;
                                if (y < minY) minY = y;
                                if (y > maxY) maxY = y;
                            }
                        }
                    }

                    if (maxX < 0) {
                        return resolve(false);
                    }

                    // Folga em volta do produto.
                    var margem = Math.round(
                        Math.max(maxX - minX + 1, maxY - minY + 1) * MARGEM
                    );

                    var x0 = Math.max(0, minX - margem);
                    var y0 = Math.max(0, minY - margem);
                    var x1 = Math.min(w - 1, maxX + margem);
                    var y1 = Math.min(h - 1, maxY + margem);

                    var cw = x1 - x0 + 1;
                    var ch = y1 - y0 + 1;

                    ctx.putImageData(dados, 0, 0);

                    var saida = document.createElement('canvas');
                    saida.width = cw;
                    saida.height = ch;

                    saida.getContext('2d').drawImage(
                        canvas,
                        x0, y0, cw, ch,
                        0, 0, cw, ch
                    );

                    saida.toBlob(function (blob) {
                        if (!blob) {
                            return resolve(false);
                        }

                        img.addEventListener('load', function () {
                            resolve(true);
                        }, { once: true });

                        img.src = URL.createObjectURL(blob);

                    }, 'image/png');

                } catch (e) {
                    // Imagem de outro domínio, falta de memória etc.: mantém a original.
                    resolve(false);
                }
            });
        }

        // Mostra a imagem (a classe js-remover-fundo no blade as mantém ocultas até aqui).
        function pronta(img) {
            img.classList.add('fundo-ok');
        }

        var imgs = Array.prototype.slice.call(
            document.querySelectorAll('.produtos-page .produto-imagem img')
        );

        /*
         * AJUSTE DO ENQUADRAMENTO DAS IMAGENS
         */

        function ajustarEnquadramento(img, fundoRemovido) {
            if (fundoRemovido || !img.naturalWidth || !img.naturalHeight) {
                return;
            }

            var area = img.closest('.produto-imagem');

            if (!area || !area.clientWidth || !area.clientHeight) {
                return;
            }

            var proporcaoImagem = img.naturalWidth / img.naturalHeight;
            var proporcaoArea = area.clientWidth / area.clientHeight;

            var diferenca = Math.abs(proporcaoImagem - proporcaoArea) / proporcaoArea;

            // Só preenche imagens horizontais com proporção semelhante à área.
            if (proporcaoImagem > 1 && diferenca <= 0.08) {
                area.classList.add('produto-imagem--preencher');
            }
        }

        imgs.forEach(function (img) {
            carregada(img)
                .then(function () {
                    return processar(img);
                })
                .catch(function () {
                    return false;
                })
                .then(function (fundoRemovido) {
                    ajustarEnquadramento(img, fundoRemovido);
                    pronta(img);
                });
        });

        // Segurança: nenhuma imagem fica escondida por mais de 5 segundos.
        setTimeout(function () {
            imgs.forEach(pronta);
        }, 5000);


        /*
         * DROPDOWNS DOS FILTROS
         */

        const dropdowns = document.querySelectorAll(
            '.produtos-filtros [data-dropdown]'
        );

        function fecharTodos(excecao) {
            dropdowns.forEach(function (dropdown) {
                if (dropdown !== excecao) {
                    dropdown.classList.remove('aberto');

                    const trigger = dropdown.querySelector('.dropdown-trigger');

                    if (trigger) {
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }

        dropdowns.forEach(function (dropdown) {
            const trigger = dropdown.querySelector('.dropdown-trigger');
            const valor = dropdown.querySelector('.dropdown-valor');
            const opcoes = dropdown.querySelectorAll('.dropdown-opcao');

            const input = dropdown.parentElement
                ? dropdown.parentElement.querySelector('input[type="hidden"]')
                : null;

            if (!trigger || !valor) {
                return;
            }

            trigger.addEventListener('click', function () {
                const abrir = !dropdown.classList.contains('aberto');

                fecharTodos(dropdown);

                dropdown.classList.toggle('aberto', abrir);
                trigger.setAttribute('aria-expanded', String(abrir));
            });

            opcoes.forEach(function (opcao) {
                opcao.addEventListener('click', function () {
                    if (input) {
                        input.value = opcao.dataset.value || '';
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }

                    valor.textContent = opcao.textContent.trim();

                    opcoes.forEach(function (item) {
                        const selecionada = item === opcao;

                        item.classList.toggle('selecionada', selecionada);
                        item.setAttribute('aria-selected', String(selecionada));
                    });

                    dropdown.classList.remove('aberto');
                    trigger.setAttribute('aria-expanded', 'false');
                });
            });

            trigger.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    dropdown.classList.remove('aberto');
                    trigger.setAttribute('aria-expanded', 'false');
                }
            });
        });

        document.addEventListener('click', function (event) {
            if (
                !(event.target instanceof Element) ||
                !event.target.closest('.produtos-filtros [data-dropdown]')
            ) {
                fecharTodos(null);
            }
        });

    });

})();