/* =========================================================
   ADMIN - AGENDAMENTOS (visão calendário / agenda)
   Lê os .ag-item renderizados pelo Blade e monta o calendário.
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    const fonte = document.getElementById('ag-fonte');
    const grade = document.getElementById('ag-cal-grade');
    if (!fonte || !grade) return;

    const MESES = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    const DIAS = ['domingo','segunda-feira','terça-feira','quarta-feira','quinta-feira','sexta-feira','sábado'];

    const titulo = document.getElementById('ag-cal-titulo');
    const diaSemana = document.getElementById('ag-dia-semana');
    const diaTitulo = document.getElementById('ag-dia-titulo');
    const diaContagem = document.getElementById('ag-dia-contagem');
    const diaLista = document.getElementById('ag-dia-lista');
    const diaVazio = document.getElementById('ag-dia-vazio');

    const iso = (d) => d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');

    /* agrupa por data */
    const porData = {};
    fonte.querySelectorAll('.ag-item').forEach(function (el) {
        const k = el.dataset.data;
        (porData[k] = porData[k] || []).push(el);
    });
    Object.keys(porData).forEach(function (k) {
        porData[k].sort((a, b) => a.dataset.hora.localeCompare(b.dataset.hora));
    });

    const hoje = new Date();
    let mesAtual = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
    let selecionado = iso(hoje);

    const classeStatus = (s) => s === '1' ? 'concluido' : (s === '2' ? 'atrasado' : 'pendente');

    function desenharCalendario() {
        titulo.textContent = MESES[mesAtual.getMonth()] + ' ' + mesAtual.getFullYear();
        grade.innerHTML = '';

        const primeiro = new Date(mesAtual.getFullYear(), mesAtual.getMonth(), 1);
        const inicio = new Date(primeiro);
        inicio.setDate(1 - primeiro.getDay());

        const diasNoMes = new Date(mesAtual.getFullYear(), mesAtual.getMonth() + 1, 0).getDate();
        const semanas = Math.ceil((primeiro.getDay() + diasNoMes) / 7);

        for (let i = 0; i < semanas * 7; i++) {
            const d = new Date(inicio);
            d.setDate(inicio.getDate() + i);
            const k = iso(d);
            const eventos = porData[k] || [];

            const cel = document.createElement('button');
            cel.type = 'button';
            cel.className = 'ag-dia-cel';
            if (d.getMonth() !== mesAtual.getMonth()) cel.classList.add('fora');
            if (k === iso(hoje)) cel.classList.add('hoje');
            if (k === selecionado) cel.classList.add('selecionado');
            cel.dataset.data = k;

            let html = '<span class="ag-num">' + d.getDate() + '</span>';
            eventos.slice(0, 2).forEach(function (ev) {
                const nome = document.createElement('span');
                nome.textContent = ev.dataset.cliente;
                html += '<span class="ag-ev ag-ev-' + classeStatus(ev.dataset.status) + '">' +
                        '<b>' + ev.dataset.hora + '</b> ' + nome.innerHTML + '</span>';
            });
            if (eventos.length > 2) {
                html += '<span class="ag-mais">+' + (eventos.length - 2) + ' mais</span>';
            }
            if (eventos.length) {
                html += '<span class="ag-contador">' + eventos.length + '</span>';
            }
            cel.innerHTML = html;

            cel.addEventListener('click', function () {
                selecionado = k;
                const alvo = new Date(k + 'T00:00:00');
                if (alvo.getMonth() !== mesAtual.getMonth()) {
                    mesAtual = new Date(alvo.getFullYear(), alvo.getMonth(), 1);
                }
                desenharCalendario();
                desenharDia();
            });

            grade.appendChild(cel);
        }
    }

    function desenharDia() {
        const d = new Date(selecionado + 'T00:00:00');
        const eventos = porData[selecionado] || [];

        diaSemana.textContent = DIAS[d.getDay()].charAt(0).toUpperCase() + DIAS[d.getDay()].slice(1) +
                                (selecionado === iso(hoje) ? ' · hoje' : '');
        diaTitulo.textContent = d.getDate() + ' de ' + MESES[d.getMonth()].toLowerCase();
        diaContagem.textContent = eventos.length === 0 ? 'Livre' :
            eventos.length + (eventos.length === 1 ? ' atendimento' : ' atendimentos');

        diaLista.innerHTML = '';
        eventos.forEach(function (ev) {
            const clone = ev.cloneNode(true);
            clone.classList.add('ag-item-' + classeStatus(ev.dataset.status));
            diaLista.appendChild(clone);
        });

        diaVazio.style.display = eventos.length ? 'none' : 'flex';
    }

    document.getElementById('ag-cal-anterior').addEventListener('click', function () {
        mesAtual = new Date(mesAtual.getFullYear(), mesAtual.getMonth() - 1, 1);
        desenharCalendario();
    });

    document.getElementById('ag-cal-proximo').addEventListener('click', function () {
        mesAtual = new Date(mesAtual.getFullYear(), mesAtual.getMonth() + 1, 1);
        desenharCalendario();
    });

    document.getElementById('ag-cal-hoje').addEventListener('click', function () {
        mesAtual = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
        selecionado = iso(hoje);
        desenharCalendario();
        desenharDia();
    });

    desenharCalendario();
    desenharDia();
});
