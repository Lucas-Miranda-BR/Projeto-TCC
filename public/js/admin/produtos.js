document.addEventListener('DOMContentLoaded', function () {

    const pesquisa = document.getElementById('pesquisa-produtos');
    const todasLinhas = Array.from(document.querySelectorAll('.produto-linha'));
    const contador = document.getElementById('contador-produtos');
    const pagination = document.getElementById('produtos-pagination');
    const numeros = document.getElementById('pagination-numeros');
    const anterior = document.getElementById('pagination-anterior');
    const proximo = document.getElementById('pagination-proximo');
    const nenhumProduto = document.getElementById('nenhum-produto-pesquisa');

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