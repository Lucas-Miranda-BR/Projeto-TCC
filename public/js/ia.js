document.addEventListener('DOMContentLoaded', function () {

    let procedimentos = window.dadosProcedimentos || [];

    let imagemInput = document.getElementById('imagem');
    let previewContainer = document.getElementById('previewContainer');
    let previewImagem = document.getElementById('previewImagem');
    let removerImagem = document.getElementById('removerImagem');
    let imagemAntes = document.getElementById('imagemAntes');
    let imagemDepois = document.getElementById('imagemDepois');
    let resultado = document.getElementById('resultado');
    let loading = document.getElementById('loading');
    let btnGerar = document.getElementById('btnGerar');
    
    let selectProcedimento = document.getElementById('procedimento_id');
    let selectCor = document.getElementById('cor_id');
    let grupoCor = document.getElementById('grupo-cor');

    if (selectProcedimento) {
        selectProcedimento.addEventListener('change', function () {
            const idSelecionado = this.value;
            
            const procedimento = procedimentos.find(p => p.procedimento_id == idSelecionado);

            if (procedimento && procedimento.tipos && procedimento.tipos.colorivel) {
                grupoCor.style.display = 'block'; 
            } else {
                grupoCor.style.display = 'none';
                selectCor.value = ""; 
            }
        });
    }

    if (imagemInput) {
        imagemInput.addEventListener('change', function () {
            const arquivo = this.files[0];
            if (!arquivo) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImagem.src = e.target.result;
                imagemAntes.src = e.target.result;
                previewContainer.classList.add('active');
            };
            reader.readAsDataURL(arquivo);
        });
    }

    if (removerImagem) {
        removerImagem.addEventListener('click', function () {
            imagemInput.value = '';
            previewImagem.src = '';
            imagemAntes.src = '';
            previewContainer.classList.remove('active');
        });
    }

    if (btnGerar) {
        btnGerar.addEventListener('click', function () {
            const arquivo = imagemInput.files[0];
            const procedimentoVal = selectProcedimento.value;
            const corVal = selectCor.value;

            if (!arquivo) {
                alert('Por favor, escolha uma foto.');
                return;
            }

            if (!procedimentoVal) {
                alert('Escolha um procedimento.');
                return;
            }

            if (grupoCor.style.display === 'block' && !corVal) {
                alert('Escolha uma cor.');
                return;
            }

            resultado.classList.add('active');
            loading.style.display = 'flex';
            imagemDepois.style.display = 'none';

            setTimeout(function () {
                imagemDepois.src = imagemAntes.src;
                loading.style.display = 'none';
                imagemDepois.style.display = 'block';
            }, 2000);

            resultado.scrollIntoView({ behavior: 'smooth' });
        });
    }
});