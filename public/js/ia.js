document.addEventListener('DOMContentLoaded', function () {
    // Apenas interface: a integração com a IA ainda não foi feita.

    var inputFoto   = document.getElementById('imagem_prompt');
    var areaUpload  = document.getElementById('uploadArea');
    var previewBox  = document.getElementById('previewContainer');
    var previewImg  = document.getElementById('previewImagem');
    var resultado   = document.getElementById('resultado');
    var removerBtn  = document.getElementById('removerImagem');

    if (inputFoto) {
        inputFoto.addEventListener('change', function () {
            var arquivo = inputFoto.files[0];
            if (!arquivo) return;

            previewImg.src = URL.createObjectURL(arquivo);
            previewBox.classList.add('active');
            areaUpload.style.display = 'none';
        });
    }

    if (removerBtn) {
        removerBtn.addEventListener('click', function () {
            inputFoto.value = '';
            previewImg.src = '';
            previewBox.classList.remove('active');
            areaUpload.style.display = '';
            if (resultado) resultado.classList.remove('active');
            var page = document.querySelector('.ia-page');
            if (page) page.classList.remove('has-result');
        });
    }

    var dropdown = document.getElementById('dropdownProcedimento');
    var grupoCor = document.getElementById('grupo-cor');
    var corInput = document.getElementById('cor_id');

    if (dropdown) {
        var gatilho = dropdown.querySelector('.dropdown-trigger');
        var opcoes  = dropdown.querySelectorAll('.dropdown-option');

        function fecharDropdown() {
            dropdown.classList.remove('open');
            if (gatilho) gatilho.setAttribute('aria-expanded', 'false');
        }

        if (gatilho) {
            gatilho.addEventListener('click', function () {
                var aberto = dropdown.classList.toggle('open');
                gatilho.setAttribute('aria-expanded', aberto ? 'true' : 'false');
            });
        }

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

                var procInput = document.getElementById('procedimento_id');
                var procLabel = document.getElementById('procedimentoSelecionado');
                if (procInput) procInput.value = opcao.dataset.value;
                if (procLabel) procLabel.textContent = opcao.textContent.trim();
                if (gatilho) gatilho.classList.add('selected');

                if (corInput) corInput.value = '';
                if (grupoCor) grupoCor.hidden = opcao.dataset.usaCor !== '1';

                fecharDropdown();
            });
        });
    }

    var formIa = document.querySelector('.ia-form');
    if (formIa) {
        formIa.addEventListener('submit', function (evento) {
            evento.preventDefault();

            if (!inputFoto || !inputFoto.files[0]) {
                if (inputFoto) inputFoto.click();
                return;
            }

            var imgAntes = document.getElementById('imagemAntes');
            if (imgAntes) imgAntes.src = previewImg.src;
            if (resultado) resultado.classList.add('active');
            var page = document.querySelector('.ia-page');
            if (page) page.classList.add('has-result');
        });
    }

    var btnNova = document.getElementById('btnNova');
    if (btnNova) {
        btnNova.addEventListener('click', function () {
            if (resultado) resultado.classList.remove('active');
            var page = document.querySelector('.ia-page');
            if (page) page.classList.remove('has-result');
        });
    }
});