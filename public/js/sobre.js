/*
 * sobre.js
 * Página "Sobre": segura a animação da introdução até a foto estar carregada,
 * para texto e foto entrarem juntos mesmo com internet lenta.
 * Sem JS, a animação roda normalmente.
 *
 * IMPORTANTE: este arquivo precisa ser carregado logo depois da seção .about-hero
 * (sem defer/async), para a classe "is-waiting" ser aplicada antes da animação começar.
 */

(function () {
    var hero = document.querySelector('.about-hero');
    var photo = document.querySelector('.about-photo');
    if (!hero || !photo) return;

    var started = false;

    function start() {
        if (started) return;
        started = true;

        requestAnimationFrame(function () {
            hero.classList.remove('is-waiting');
        });
    }

    hero.classList.add('is-waiting');

    if (photo.decode) {
        photo.decode().then(start, start);
    } else if (photo.complete) {
        start();
    } else {
        photo.onload = photo.onerror = start;
    }

    // internet muito lenta: não deixa o texto esperando para sempre
    setTimeout(start, 2500);
})();