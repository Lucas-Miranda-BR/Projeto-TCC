/* =========================================================
   SERVIÇOS — carrossel deslizável + paleta de tons
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- carrossel (coverflow) ---------- */
    const palco = document.getElementById('sv-trilho');
    if (palco) {
        const cards = Array.from(palco.querySelectorAll('.sv-card'));
        const btnAnt = document.getElementById('sv-anterior');
        const btnProx = document.getElementById('sv-proximo');
        const pontos = document.getElementById('sv-pontos');
        let atual = 0;

        cards.forEach(function (_, i) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'sv-ponto';
            b.setAttribute('aria-label', 'Ir para o serviço ' + (i + 1));
            b.addEventListener('click', function () { ir(i); });
            pontos.appendChild(b);
        });

        function ir(i) {
            atual = Math.max(0, Math.min(cards.length - 1, i));
            cards.forEach(function (c, n) {
                const pos = n - atual;
                if (Math.abs(pos) <= 2) c.setAttribute('data-pos', pos);
                else c.removeAttribute('data-pos');
                c.setAttribute('aria-hidden', pos === 0 ? 'false' : 'true');
                c.querySelectorAll('a').forEach(function (a) { a.tabIndex = pos === 0 ? 0 : -1; });
            });
            pontos.querySelectorAll('.sv-ponto').forEach(function (p, n) { p.classList.toggle('ativo', n === atual); });
            if (btnAnt) btnAnt.disabled = atual === 0;
            if (btnProx) btnProx.disabled = atual === cards.length - 1;
        }

        if (btnAnt) btnAnt.addEventListener('click', function () { ir(atual - 1); });
        if (btnProx) btnProx.addEventListener('click', function () { ir(atual + 1); });

        palco.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') { e.preventDefault(); ir(atual + 1); }
            if (e.key === 'ArrowLeft')  { e.preventDefault(); ir(atual - 1); }
        });

        /* deslizar (dedo ou mouse) e clicar nos cards de trás */
        let apertado = false, inicioX = 0, moveu = false;

        palco.addEventListener('pointerdown', function (e) {
            if (e.pointerType === 'mouse' && e.button !== 0) return;
            apertado = true; moveu = false; inicioX = e.clientX;
        });
        window.addEventListener('pointermove', function (e) {
            if (!apertado) return;
            if (Math.abs(e.clientX - inicioX) > 8) { moveu = true; palco.classList.add('arrastando'); }
        });
        function soltar(e) {
            if (!apertado) return;
            apertado = false;
            palco.classList.remove('arrastando');
            const dx = e.clientX - inicioX;
            if (moveu && Math.abs(dx) > 40) ir(atual + (dx < 0 ? 1 : -1));
        }
        window.addEventListener('pointerup', soltar);
        window.addEventListener('pointercancel', function () { apertado = false; palco.classList.remove('arrastando'); });

        palco.addEventListener('click', function (e) {
            if (moveu) { e.preventDefault(); e.stopPropagation(); moveu = false; return; }
            const card = e.target.closest('.sv-card');
            if (card && card.getAttribute('data-pos') !== '0') {
                e.preventDefault();
                ir(parseInt(card.dataset.indice, 10));
            }
        }, true);

        palco.querySelectorAll('img').forEach(function (img) { img.draggable = false; });
        ir(0);
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
