
    // Apenas interface: a integração com a IA ainda não foi feita.

    var inputFoto   = document.getElementById('imagem_prompt');
    var areaUpload  = document.getElementById('uploadArea');
    var previewBox  = document.getElementById('previewContainer');
    var previewImg  = document.getElementById('previewImagem');
    var resultado   = document.getElementById('resultado');

    inputFoto.addEventListener('change', function () {
        var arquivo = inputFoto.files[0];
        if (!arquivo) return;

        previewImg.src = URL.createObjectURL(arquivo);
        previewBox.classList.add('active');
        areaUpload.style.display = 'none';
    });

    document.getElementById('removerImagem').addEventListener('click', function () {
        inputFoto.value = '';
        previewImg.src = '';
        previewBox.classList.remove('active');
        areaUpload.style.display = '';
        resultado.classList.remove('active');
        document.querySelector('.ia-page').classList.remove('has-result');
    });


    /* Procedimento: dropdown único */
    var dropdown     = document.getElementById('dropdownProcedimento');
    var gatilho      = dropdown.querySelector('.dropdown-trigger');
    var opcoes       = dropdown.querySelectorAll('.dropdown-option');
    var grupoCor     = document.getElementById('grupo-cor');
    var cores        = document.querySelectorAll('#listaCores .option-color');

    function fecharDropdown() {
        dropdown.classList.remove('open');
        gatilho.setAttribute('aria-expanded', 'false');
    }

    gatilho.addEventListener('click', function () {
        var aberto = dropdown.classList.toggle('open');
        gatilho.setAttribute('aria-expanded', aberto ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target)) fecharDropdown();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') fecharDropdown();
    });

    opcoes.forEach(function (opcao) {
        opcao.addEventListener('click', function () {

            opcoes.forEach(function (o) {
                o.classList.remove('selected');
                o.setAttribute('aria-selected', 'false');
            });

            opcao.classList.add('selected');
            opcao.setAttribute('aria-selected', 'true');

            document.getElementById('procedimento_id').value = opcao.dataset.value;
            document.getElementById('procedimentoSelecionado').textContent = opcao.textContent.trim();
            gatilho.classList.add('selected');

            /* troca de procedimento limpa a cor */
            document.getElementById('cor_id').value = '';
            cores.forEach(function (c) { c.classList.remove('selected'); });

            grupoCor.hidden = opcao.dataset.usaCor !== '1';

            fecharDropdown();
        });
    });

    cores.forEach(function (cor) {
        cor.addEventListener('click', function () {
            cores.forEach(function (c) { c.classList.remove('selected'); });
            cor.classList.add('selected');
            document.getElementById('cor_id').value = cor.dataset.value;
        });
    });


    /* Botão: só mostra o layout do resultado (sem chamar IA) */
    document.querySelector('.ia-form').addEventListener('submit', function (evento) {
        evento.preventDefault();

        if (!inputFoto.files[0]) {
            inputFoto.click();
            return;
        }

        document.getElementById('imagemAntes').src = previewImg.src;
        resultado.classList.add('active');
        document.querySelector('.ia-page').classList.add('has-result');
    });

    document.getElementById('btnNova').addEventListener('click', function () {
        resultado.classList.remove('active');
        document.querySelector('.ia-page').classList.remove('has-result');
    });