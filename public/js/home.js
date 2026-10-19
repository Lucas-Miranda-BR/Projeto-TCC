(function () {
    var hero = document.querySelector('.home-hero');
    if (!hero) return;

    var started = false;

    function start() {
        if (started) return;
        started = true;

        requestAnimationFrame(function () {
            hero.classList.remove('is-waiting');
        });
    }

    hero.classList.add('is-waiting');

    var img = new Image();
    
    img.src = "public/images/8fe6d343-1ce3-4871-a71a-f631d1484826.jpg";

    if (img.decode) {
        img.decode().then(start, start);
    } else {
        img.onload = img.onerror = start;
    }

    setTimeout(start, 2500);
})();