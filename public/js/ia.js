document.addEventListener('DOMContentLoaded', function () {

    let procedimentos = window.dadosProcedimentos || [];

    let imagemInput = document.getElementById('imagem_prompt');
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
            let idSelecionado = this.value;
            
            let procedimento = procedimentos.find(p => p.procedimento_id == idSelecionado);

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
            let arquivo = this.files[0];
            if (!arquivo) return;

            let reader = new FileReader();
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
        btnGerar.addEventListener('click', function (e) {
            e.preventDefault();

            let arquivo = imagemInput.files[0];
            let procedimentoVal = selectProcedimento.value;
            let corVal = selectCor.value;

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
            resultado.scrollIntoView({ behavior: 'smooth' });

            let form = document.querySelector('form');
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Sucesso! Dados salvos no backend:', data);
                
                if (data.redirect_url) {
                    let btnAgendar = document.querySelector('.btn-agendar');
                    if (btnAgendar) {
                        btnAgendar.href = data.redirect_url;
                    }
                }
            })
            .catch(error => {
                console.error('Erro ao enviar form:', error);
            });

            setTimeout(function () {
                imagemDepois.src = imagemAntes.src;
                loading.style.display = 'none';
                imagemDepois.style.display = 'block';
            }, 2000);

            resultado.scrollIntoView({ behavior: 'smooth' });
        });
    }
});