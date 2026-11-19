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

    // Dropdown de Procedimento e Dropdown de Cor
    var dropdownProc = document.getElementById('dropdownProcedimento');
    var dropdownCor  = document.getElementById('dropdownCor');
    var grupoCor     = document.getElementById('grupo-cor');
    var corInput     = document.getElementById('cor_id');
    var corLabel     = document.getElementById('corSelecionada');

    function fecharDropdown(dd) {
        if (!dd) return;
        dd.classList.remove('open');
        var trigger = dd.querySelector('.dropdown-trigger');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
    }

    function resetarCor() {
        if (corInput) corInput.value = '';
        if (corLabel) corLabel.textContent = 'Selecione uma cor';
        if (dropdownCor) {
            var triggerCor = dropdownCor.querySelector('.dropdown-trigger');
            if (triggerCor) triggerCor.classList.remove('selected');
            dropdownCor.querySelectorAll('.dropdown-option').forEach(function (o) {
                o.classList.remove('selected');
                o.setAttribute('aria-selected', 'false');
            });
        }
    }

    if (dropdownProc) {
        var gatilhoProc = dropdownProc.querySelector('.dropdown-trigger');
        var opcoesProc  = dropdownProc.querySelectorAll('.dropdown-option');

        if (gatilhoProc) {
            gatilhoProc.addEventListener('click', function (e) {
                e.stopPropagation();
                fecharDropdown(dropdownCor);
                var aberto = dropdownProc.classList.toggle('open');
                gatilhoProc.setAttribute('aria-expanded', aberto ? 'true' : 'false');
            });
        }

        opcoesProc.forEach(function (opcao) {
            opcao.addEventListener('click', function () {
                opcoesProc.forEach(function (o) {
                    o.classList.remove('selected');
                    o.setAttribute('aria-selected', 'false');
                });

                opcao.classList.add('selected');
                opcao.setAttribute('aria-selected', 'true');

                var procInput = document.getElementById('procedimento_id');
                var procLabel = document.getElementById('procedimentoSelecionado');
                if (procInput) procInput.value = opcao.dataset.value;
                if (procLabel) procLabel.textContent = opcao.textContent.trim();
                if (gatilhoProc) gatilhoProc.classList.add('selected');

                // Troca de procedimento limpa a cor selecionada
                resetarCor();
                if (grupoCor) grupoCor.hidden = opcao.dataset.usaCor !== '1';

                fecharDropdown(dropdownProc);
            });
        });
    }

    if (dropdownCor) {
        var gatilhoCor = dropdownCor.querySelector('.dropdown-trigger');
        var opcoesCor  = dropdownCor.querySelectorAll('.dropdown-option');

        if (gatilhoCor) {
            gatilhoCor.addEventListener('click', function (e) {
                e.stopPropagation();
                fecharDropdown(dropdownProc);
                var aberto = dropdownCor.classList.toggle('open');
                gatilhoCor.setAttribute('aria-expanded', aberto ? 'true' : 'false');
            });
        }

        opcoesCor.forEach(function (opcao) {
            opcao.addEventListener('click', function () {
                opcoesCor.forEach(function (o) {
                    o.classList.remove('selected');
                    o.setAttribute('aria-selected', 'false');
                });

                opcao.classList.add('selected');
                opcao.setAttribute('aria-selected', 'true');

                if (corInput) corInput.value = opcao.dataset.value;
                if (corLabel) corLabel.textContent = opcao.textContent.trim();
                if (gatilhoCor) gatilhoCor.classList.add('selected');

                fecharDropdown(dropdownCor);
            });
        });
    }

    document.addEventListener('click', function (e) {
        if (dropdownProc && !dropdownProc.contains(e.target)) fecharDropdown(dropdownProc);
        if (dropdownCor && !dropdownCor.contains(e.target)) fecharDropdown(dropdownCor);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            fecharDropdown(dropdownProc);
            fecharDropdown(dropdownCor);
        }
    });

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