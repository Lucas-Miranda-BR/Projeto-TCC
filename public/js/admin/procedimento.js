document.addEventListener('DOMContentLoaded', function () {
    let selectTipo = document.getElementById('tipo_id');
    let statusColorivel = document.getElementById('status-colorivel');

    if (selectTipo && statusColorivel) {
        
        function atualizarStatusColorivel() {
            let opcaoSelecionada = selectTipo.options[selectTipo.selectedIndex];

            if (opcaoSelecionada.value === "") {
                statusColorivel.style.display = 'none';
                return;
            }

            let isColorivel = opcaoSelecionada.getAttribute('data-colorivel') === '1';

            statusColorivel.style.display = 'block';

            if (isColorivel) {
                statusColorivel.textContent = 'Este tipo permite coloração.';
                statusColorivel.style.color = '#28a745';
            } else {
                statusColorivel.textContent = 'Este tipo NÃO é colorível.';
                statusColorivel.style.color = '#6c757d';
            }
        }
        selectTipo.addEventListener('change', atualizarStatusColorivel);
        atualizarStatusColorivel();
    }
});