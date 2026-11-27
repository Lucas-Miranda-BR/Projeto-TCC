/* =========================================================
   SERVIÇOS — carrossel deslizável + paleta de tons
   ========================================================= */
   document.addEventListener('DOMContentLoaded', function () {

    /* ---------- carrossel ---------- */
    const trilho = document.getElementById('sv-trilho');
    if (trilho) {
        const cards = Array.from(trilho.querySelectorAll('.sv-card'));
        const btnAnt = document.getElementById('sv-anterior');
        const btnProx = document.getElementById('sv-proximo');
        const pontos = document.getElementById('sv-pontos');

        const passo = () => {
            if (cards.length < 2) return trilho.clientWidth;
            return cards[1].offsetLeft - cards[0].offsetLeft;
        };

        /* pontos */
        cards.forEach(function (_, i) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'sv-ponto';
            b.setAttribute('aria-label', 'Ir para o serviço ' + (i + 1));
            b.addEventListener('click', function () {
                trilho.scrollTo({ left: i * passo(), behavior: 'smooth' });
            });
            pontos.appendChild(b);
        });

        function atualizar() {
            const max = trilho.scrollWidth - trilho.clientWidth;
            const atual = Math.min(cards.length - 1, Math.round(trilho.scrollLeft / passo()));
            const indice = trilho.scrollLeft >= max - 4 ? cards.length - 1 : atual;

            pontos.querySelectorAll('.sv-ponto').forEach(function (p, i) {
                p.classList.toggle('ativo', i === indice);
            });

            const meio = trilho.scrollLeft + trilho.clientWidth / 2;
            let mais = 0, dist = Infinity;
            cards.forEach(function (c, i) {
                const d = Math.abs(c.offsetLeft + c.offsetWidth / 2 - meio);
                if (d < dist) { dist = d; mais = i; }
            });
            cards.forEach(function (c, i) { c.classList.toggle('ativo', i === mais); });
            pontos.querySelectorAll('.sv-ponto').forEach(function (p, i) { p.classList.toggle('ativo', i === mais); });

            if (btnAnt) btnAnt.disabled = trilho.scrollLeft <= 4;
            if (btnProx) btnProx.disabled = trilho.scrollLeft >= max - 4;
        }

        trilho.addEventListener('scroll', function () { window.requestAnimationFrame(atualizar); }, { passive: true });
        window.addEventListener('resize', atualizar);

        let alvo = 0;
        const ir = function (i) {
            alvo = Math.max(0, Math.min(cards.length - 1, i));
            trilho.scrollTo({ left: alvo * passo(), behavior: 'smooth' });
        };
        let temporizador;
        trilho.addEventListener('scroll', function () {
            clearTimeout(temporizador);
            temporizador = setTimeout(function () { alvo = Math.round(trilho.scrollLeft / passo()); }, 140);
        }, { passive: true });
        if (btnAnt) btnAnt.addEventListener('click', function () { ir(alvo - 1); });
        if (btnProx) btnProx.addEventListener('click', function () { ir(alvo + 1); });

        trilho.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') { e.preventDefault(); ir(alvo + 1); }
            if (e.key === 'ArrowLeft')  { e.preventDefault(); ir(alvo - 1); }
        });

        /* arrastar com o mouse (toque já funciona nativamente) */
        let apertado = false, inicioX = 0, inicioScroll = 0, moveu = false;

        trilho.addEventListener('pointerdown', function (e) {
            if (e.pointerType !== 'mouse') return;
            apertado = true; moveu = false;
            inicioX = e.clientX; inicioScroll = trilho.scrollLeft;
        });

        window.addEventListener('pointermove', function (e) {
            if (!apertado) return;
            const dx = e.clientX - inicioX;
            if (Math.abs(dx) > 5) { moveu = true; trilho.classList.add('arrastando'); }
            if (moveu) trilho.scrollLeft = inicioScroll - dx;
        });

        function soltar() {
            if (!apertado) return;
            apertado = false;
            if (moveu) {
                trilho.classList.remove('arrastando');
                trilho.scrollTo({ left: Math.round(trilho.scrollLeft / passo()) * passo(), behavior: 'smooth' });
            }
        }
        window.addEventListener('pointerup', soltar);
        window.addEventListener('pointercancel', soltar);

        atualizar();
    }

    /* ---------- paleta de tons ---------- */
    const paleta = document.getElementById('sv-paleta');
    const escolhido = document.getElementById('sv-paleta-escolhido');

    if (paleta && escolhido) {
        paleta.querySelectorAll('.sv-tom').forEach(function (btn) {
            btn.addEventListener('click', function () {
                paleta.querySelectorAll('.sv-tom').forEach(function (b) { b.classList.remove('ativo'); });
                btn.classList.add('ativo');

                escolhido.innerHTML = 'Tom <strong>' + btn.dataset.nivel + ' · ' + btn.dataset.nome + '</strong>' +
                    '<a href="' + (escolhido.dataset.agendar || '#') + '">Agendar coloração</a>';
            });
        });
    }
});
