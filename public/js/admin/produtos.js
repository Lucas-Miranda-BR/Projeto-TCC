document.addEventListener('DOMContentLoaded', function () {

    const pesquisa = document.getElementById('pesquisa-produtos');
    const todasLinhas = Array.from(document.querySelectorAll('.produto-linha'));
    const contador = document.getElementById('contador-produtos');
    const pagination = document.getElementById('produtos-pagination');
    const numeros = document.getElementById('pagination-numeros');
    const anterior = document.getElementById('pagination-anterior');
    const proximo = document.getElementById('pagination-proximo');
    const nenhumProduto = document.getElementById('nenhum-produto-pesquisa');

    // só roda na tela de listagem (na tela de editar não existe a tabela de produtos)
    if (!pesquisa) {
        return;
    }

    const produtosPorPagina = 5;
    let paginaAtual = 1;
    let linhasFiltradas = [...todasLinhas];

    function normalizarTexto(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
    }

    function filtrarProdutos() {
        const termo = normalizarTexto(pesquisa.value.trim());

        linhasFiltradas = todasLinhas.filter(function (linha) {
            const dados = normalizarTexto(linha.dataset.pesquisa || '');
            return dados.includes(termo);
        });

        paginaAtual = 1;
        renderizarPagina();
    }

    function renderizarPagina() {
        todasLinhas.forEach(function (linha) {
            linha.style.display = 'none';
        });

        const totalProdutos = linhasFiltradas.length;
        const totalPaginas = Math.ceil(totalProdutos / produtosPorPagina);

        if (paginaAtual > totalPaginas && totalPaginas > 0) {
            paginaAtual = totalPaginas;
        }

        const inicio = (paginaAtual - 1) * produtosPorPagina;
        const fim = inicio + produtosPorPagina;
        const produtosPagina = linhasFiltradas.slice(inicio, fim);

        produtosPagina.forEach(function (linha) {
            linha.style.display = '';
        });

        atualizarContador(inicio, produtosPagina.length, totalProdutos);
        criarPaginacao(totalPaginas);

        if (totalProdutos === 0) {
            nenhumProduto.style.display = 'flex';
            pagination.style.display = 'none';
        } else {
            nenhumProduto.style.display = 'none';
            pagination.style.display = totalPaginas > 1 ? 'flex' : 'none';
        }
    }

    function atualizarContador(inicio, quantidadePagina, total) {
        if (total === 0) {
            contador.textContent = 'Nenhum produto encontrado';
            return;
        }

        const primeiro = inicio + 1;
        const ultimo = inicio + quantidadePagina;
        
        contador.textContent = 'Exibindo ' + primeiro + '-' + ultimo + ' de ' + total + ' produtos';
    }

    function criarPaginacao(totalPaginas) {
        numeros.innerHTML = '';
        anterior.disabled = paginaAtual === 1;
        proximo.disabled = paginaAtual === totalPaginas || totalPaginas === 0;

        for (let pagina = 1; pagina <= totalPaginas; pagina++) {
            const botao = document.createElement('button');
            botao.type = 'button';
            botao.textContent = pagina;
            botao.className = 'pagination-num';

            if (pagina === paginaAtual) {
                botao.classList.add('active');
            }

            botao.addEventListener('click', function () {
                paginaAtual = pagina;
                renderizarPagina();
            });

            numeros.appendChild(botao);
        }
    }

    anterior.addEventListener('click', function () {
        if (paginaAtual > 1) {
            paginaAtual--;
            renderizarPagina();
        }
    });

    proximo.addEventListener('click', function () {
        const totalPaginas = Math.ceil(linhasFiltradas.length / produtosPorPagina);
        if (paginaAtual < totalPaginas) {
            paginaAtual++;
            renderizarPagina();
        }
    });

    pesquisa.addEventListener('input', filtrarProdutos);

    renderizarPagina();
});


/* Paginação das listas laterais (Categorias e Marcas): 4 itens por página */
document.addEventListener('DOMContentLoaded', function () {

    const itensPorPagina = 4;

    document.querySelectorAll('.produtos-lateral .lateral-lista').forEach(function (lista) {

        const itens = Array.from(lista.querySelectorAll('.lateral-item'));

        if (itens.length <= itensPorPagina) {
            return;
        }

        const totalPaginas = Math.ceil(itens.length / itensPorPagina);
        let paginaAtual = 1;

        const barra = document.createElement('div');
        barra.className = 'lateral-paginacao';

        const info = document.createElement('span');
        info.className = 'lateral-pag-info';

        const botoes = document.createElement('div');
        botoes.className = 'lateral-pag-botoes';

        barra.appendChild(info);
        barra.appendChild(botoes);
        lista.insertAdjacentElement('afterend', barra);

        function criarBotao(texto, aoClicar, desabilitado, ativo) {
            const botao = document.createElement('button');
            botao.type = 'button';
            botao.className = 'lateral-pag-btn' + (ativo ? ' active' : '');
            botao.textContent = texto;
            botao.disabled = !!desabilitado;
            botao.addEventListener('click', aoClicar);
            return botao;
        }

        function renderizar() {
            const inicio = (paginaAtual - 1) * itensPorPagina;
            const fim = inicio + itensPorPagina;

            itens.forEach(function (item, indice) {
                item.style.display = (indice >= inicio && indice < fim) ? '' : 'none';
            });

            info.textContent = (inicio + 1) + '–' + Math.min(fim, itens.length) + ' de ' + itens.length;

            botoes.innerHTML = '';
            botoes.appendChild(criarBotao('‹', function () {
                paginaAtual--;
                renderizar();
            }, paginaAtual === 1));

            for (let p = 1; p <= totalPaginas; p++) {
                botoes.appendChild(criarBotao(p, function () {
                    paginaAtual = p;
                    renderizar();
                }, false, p === paginaAtual));
            }

            botoes.appendChild(criarBotao('›', function () {
                paginaAtual++;
                renderizar();
            }, paginaAtual === totalPaginas));
        }

        renderizar();
    });
});


/* =========================================================
   SALÃO SEMPRE DIVA
   ADMIN - DROPDOWN (select) ESTILIZADO + PREVIEW DE FOTO
   - Troca o visual dos <select> dentro de .form-group
   - O <select> original continua no formulário e envia o valor
   ========================================================= */

/* Pré-visualização da foto (usada no onchange dos campos de foto) */
function previewImagem(event, idImagem) {
    const imagem = document.getElementById(idImagem);
    const arquivo = event.target.files && event.target.files[0];

    if (!imagem || !arquivo) {
        return;
    }

    const leitor = new FileReader();

    leitor.onload = function (e) {
        imagem.src = e.target.result;
        imagem.style.display = 'block';
    };

    leitor.readAsDataURL(arquivo);
}


(function () {

    let contador = 0;
    const abertos = new Set();

    function fecharTodos(exceto) {
        abertos.forEach(function (fechar) {
            if (fechar !== exceto) {
                fechar();
            }
        });
    }

    function montar(select) {
        if (select.dataset.selectCustom) {
            return;
        }

        select.dataset.selectCustom = '1';
        contador++;

        const idBase = 'select-custom-' + contador;

        const wrapper = document.createElement('div');
        wrapper.className = 'select-custom';

        const botao = document.createElement('button');
        botao.type = 'button';
        botao.className = 'select-custom__trigger';
        botao.setAttribute('aria-haspopup', 'listbox');
        botao.setAttribute('aria-expanded', 'false');
        botao.disabled = select.disabled;

        const valor = document.createElement('span');
        valor.className = 'select-custom__valor';

        const seta = document.createElement('span');
        seta.className = 'select-custom__seta';
        seta.setAttribute('aria-hidden', 'true');

        botao.appendChild(valor);
        botao.appendChild(seta);

        const menu = document.createElement('ul');
        menu.className = 'select-custom__menu';
        menu.id = idBase + '-lista';
        menu.setAttribute('role', 'listbox');
        botao.setAttribute('aria-controls', menu.id);

        const opcoes = Array.from(select.options).map(function (opt, i) {
            const li = document.createElement('li');
            li.className = 'select-custom__option' + (opt.value === '' ? ' is-vazio' : '');
            li.id = idBase + '-opt-' + i;
            li.setAttribute('role', 'option');
            li.dataset.indice = i;

            const texto = document.createElement('span');
            texto.textContent = opt.textContent.trim();
            li.appendChild(texto);

            li.title = texto.textContent;
            menu.appendChild(li);

            return li;
        });

        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(botao);
        wrapper.appendChild(menu);
        wrapper.appendChild(select);

        select.classList.add('select-custom__native');
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');

        let ativo = select.selectedIndex;
        let busca = '';
        let buscaTimer = null;

        function atualizar() {
            const escolhido = select.options[select.selectedIndex];

            valor.textContent = escolhido ? escolhido.textContent.trim() : '';
            wrapper.classList.toggle('is-placeholder', !escolhido || escolhido.value === '');

            opcoes.forEach(function (li, i) {
                const selecionado = i === select.selectedIndex;

                li.classList.toggle('is-selecionado', selecionado);
                li.setAttribute('aria-selected', selecionado ? 'true' : 'false');
            });
        }

        function marcarAtivo(indice, rolar) {
            ativo = Math.max(0, Math.min(opcoes.length - 1, indice));

            opcoes.forEach(function (li, i) {
                li.classList.toggle('is-ativo', i === ativo);
            });

            botao.setAttribute('aria-activedescendant', opcoes[ativo] ? opcoes[ativo].id : '');

            if (rolar !== false && opcoes[ativo]) {
                opcoes[ativo].scrollIntoView({ block: 'nearest' });
            }
        }

        function abrir() {
            if (select.disabled) {
                return;
            }

            fecharTodos(fechar);

            wrapper.classList.remove('is-drop-up');

            const caixa = wrapper.getBoundingClientRect();
            const alturaMenu = Math.min(menu.scrollHeight, 232) + 12;
            const abaixo = window.innerHeight - caixa.bottom;

            if (abaixo < alturaMenu && caixa.top > abaixo) {
                wrapper.classList.add('is-drop-up');
            }

            wrapper.classList.add('is-open');
            botao.setAttribute('aria-expanded', 'true');
            abertos.add(fechar);

            marcarAtivo(select.selectedIndex);
        }

        function fechar() {
            wrapper.classList.remove('is-open');
            botao.setAttribute('aria-expanded', 'false');
            abertos.delete(fechar);
        }

        function escolher(indice) {
            if (select.selectedIndex !== indice) {
                select.selectedIndex = indice;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }

            atualizar();
            fechar();
            botao.focus();
        }

        botao.addEventListener('click', function () {
            if (wrapper.classList.contains('is-open')) {
                fechar();
            } else {
                abrir();
            }
        });

        menu.addEventListener('mousedown', function (e) {
            e.preventDefault();
        });

        menu.addEventListener('click', function (e) {
            const li = e.target.closest('.select-custom__option');

            if (li) {
                escolher(Number(li.dataset.indice));
            }
        });

        menu.addEventListener('mousemove', function (e) {
            const li = e.target.closest('.select-custom__option');

            if (li && Number(li.dataset.indice) !== ativo) {
                marcarAtivo(Number(li.dataset.indice), false);
            }
        });

        botao.addEventListener('keydown', function (e) {
            const aberto = wrapper.classList.contains('is-open');

            switch (e.key) {
                case 'ArrowDown':
                case 'ArrowUp':
                    e.preventDefault();

                    if (!aberto) {
                        abrir();
                    } else {
                        marcarAtivo(ativo + (e.key === 'ArrowDown' ? 1 : -1));
                    }
                    break;

                case 'Home':
                    if (aberto) { e.preventDefault(); marcarAtivo(0); }
                    break;

                case 'End':
                    if (aberto) { e.preventDefault(); marcarAtivo(opcoes.length - 1); }
                    break;

                case 'Enter':
                case ' ':
                    if (aberto) {
                        e.preventDefault();
                        escolher(ativo);
                    }
                    break;

                case 'Escape':
                    if (aberto) {
                        e.preventDefault();
                        fechar();
                    }
                    break;

                case 'Tab':
                    fechar();
                    break;

                default:
                    if (e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        clearTimeout(buscaTimer);
                        busca += e.key.toLowerCase();
                        buscaTimer = setTimeout(function () { busca = ''; }, 600);

                        const achou = opcoes.findIndex(function (li) {
                            return li.textContent.trim().toLowerCase().indexOf(busca) === 0;
                        });

                        if (achou >= 0) {
                            if (aberto) {
                                marcarAtivo(achou);
                            } else {
                                select.selectedIndex = achou;
                                select.dispatchEvent(new Event('change', { bubbles: true }));
                                atualizar();
                            }
                        }
                    }
            }
        });

        // clicar no <label> do campo foca o botão
        if (select.id) {
            const label = document.querySelector('label[for="' + select.id + '"]');

            if (label) {
                label.addEventListener('click', function (e) {
                    e.preventDefault();
                    botao.focus();
                });
            }
        }

        // se o form for limpo (reset), acompanha o valor
        if (select.form) {
            select.form.addEventListener('reset', function () {
                setTimeout(atualizar, 0);
            });
        }

        select.addEventListener('change', atualizar);

        atualizar();
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.select-custom')) {
            fecharTodos();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            fecharTodos();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.produtos-content .form-group select').forEach(montar);
    });

})();