// Integração de interface e simulação local (sem chamar API externa).

var inputFoto   = document.getElementById('imagem_prompt');
var areaUpload  = document.getElementById('uploadArea');
var previewBox  = document.getElementById('previewContainer');
var previewImg  = document.getElementById('previewImagem');
var resultado   = document.getElementById('resultado');
var iaPage      = document.querySelector('.ia-page');

var imagemDepois   = document.getElementById('imagemDepois');
var placeholderIa  = document.getElementById('placeholderIa');
var btnAnexar      = document.getElementById('btnAnexarAgendamento');
var btnGerar       = document.getElementById('btnGerar');

var imagemGeradaIdAtual = null;

function atualizarLinkAgendamento() {
    if (!btnAnexar) return;

    var baseUrl = btnAnexar.dataset.baseUrl || btnAnexar.href.split('?')[0];
    var params = new URLSearchParams();
    var procId = document.getElementById('procedimento_id').value;

    if (imagemGeradaIdAtual) {
        params.set('imagem_gerada_id', imagemGeradaIdAtual);
    }
    if (procId) {
        params.set('procedimento_id', procId);
    }

    var query = params.toString();
    btnAnexar.href = query ? baseUrl + '?' + query : baseUrl;
}

function resetarPreviewDepois() {
    imagemGeradaIdAtual = null;
    if (imagemDepois) {
        imagemDepois.src = '';
        imagemDepois.style.display = 'none';
    }
    if (placeholderIa) {
        placeholderIa.style.display = '';
    }
    atualizarLinkAgendamento();
}

inputFoto.addEventListener('change', function () {
    var arquivo = inputFoto.files[0];

    if (!arquivo) return;

    previewImg.src = URL.createObjectURL(arquivo);
    previewBox.classList.add('active');
    areaUpload.style.display = 'none';
    resetarPreviewDepois();
});

document.getElementById('removerImagem').addEventListener('click', function () {
    inputFoto.value = '';
    previewImg.src = '';

    previewBox.classList.remove('active');
    areaUpload.style.display = '';

    resultado.classList.remove('active');
    if (iaPage) iaPage.classList.remove('has-result');
    resetarPreviewDepois();
});


/* ==========================================================
   PROCEDIMENTO: DROPDOWN
   ========================================================== */

var dropdown = document.getElementById('dropdownProcedimento');
var gatilho = dropdown.querySelector('.dropdown-trigger');
var opcoes = dropdown.querySelectorAll('.dropdown-option');

var grupoCor = document.getElementById('grupo-cor');
var selectCor = document.getElementById('cor_id');

function fecharDropdown() {
    dropdown.classList.remove('open');
    gatilho.setAttribute('aria-expanded', 'false');
}

gatilho.addEventListener('click', function () {
    var aberto = dropdown.classList.toggle('open');

    gatilho.setAttribute('aria-expanded', aberto ? 'true' : 'false');
});

document.addEventListener('click', function (e) {
    if (!dropdown.contains(e.target)) {
        fecharDropdown();
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        fecharDropdown();
    }
});


/* ==========================================================
   SELEÇÃO DO PROCEDIMENTO E EXIBIÇÃO DAS CORES
   ========================================================== */

opcoes.forEach(function (opcao) {
    opcao.addEventListener('click', function () {

        opcoes.forEach(function (o) {
            o.classList.remove('selected');
            o.setAttribute('aria-selected', 'false');
        });

        opcao.classList.add('selected');
        opcao.setAttribute('aria-selected', 'true');

        document.getElementById('procedimento_id').value = opcao.dataset.value;

        document.getElementById('procedimentoSelecionado').textContent =
            opcao.textContent.trim();

        gatilho.classList.add('selected');

        // Limpa a cor selecionada ao trocar de procedimento.
        selectCor.value = '';

        // Verifica se o procedimento permite escolher uma cor.
        var usaCor = opcao.dataset.usaCor === '1';

        grupoCor.hidden = !usaCor;

        // Ativa e exige a seleção de cor somente quando necessário.
        selectCor.disabled = !usaCor;
        selectCor.required = usaCor;

        atualizarLinkAgendamento();
        fecharDropdown();
    });
});


/* ==========================================================
   BOTÃO: ENVIA PROMPT, APAGA ORIGINAL TEMPORÁRIA E MOSTRA RESULTADO
   ========================================================== */

document.querySelector('.ia-form').addEventListener('submit', async function (evento) {
    evento.preventDefault();

    if (!inputFoto.files[0]) {
        inputFoto.click();
        return;
    }

    var form = this;
    var formData = new FormData(form);
    if (btnGerar) btnGerar.disabled = true;

    try {
        var response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });

        var data = await response.json();

        if (!response.ok || !data.success) {
            var msg = data.errors
                ? Object.values(data.errors).flat().join('\n')
                : (data.message || 'Erro ao processar a simulação.');
            alert(msg);
            return;
        }

        imagemGeradaIdAtual = data.imagem_gerada_id;
        atualizarLinkAgendamento();

        document.getElementById('imagemAntes').src = previewImg.src;

        if (imagemDepois && data.imagem_gerada_url) {
            imagemDepois.src = data.imagem_gerada_url;
            imagemDepois.style.display = 'block';
            if (placeholderIa) placeholderIa.style.display = 'none';
        }

        resultado.classList.add('active');
        if (iaPage) iaPage.classList.add('has-result');
    } catch (err) {
        alert('Falha na comunicação com o servidor.');
    } finally {
        if (btnGerar) btnGerar.disabled = false;
    }
});


/* ==========================================================
   NOVA SIMULAÇÃO
   ========================================================== */

document.getElementById('btnNova').addEventListener('click', function () {
    resultado.classList.remove('active');
    if (iaPage) iaPage.classList.remove('has-result');
    resetarPreviewDepois();
});