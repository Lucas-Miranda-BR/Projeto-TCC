@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Montserrat:wght@500;600&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/servicos.css') }}">
@endpush

@section('content')

    @include('components.navbar')

    @php
        /*
         * Categorias do carrossel.
         * "fotos": lista de imagens candidatas (a primeira que existir em /public/images é usada).
         * Para trocar a foto de uma categoria basta colocar o arquivo em public/images/servicos/<slug>.jpg
         * Sem foto, o card mostra um fundo degradê com o ícone da categoria.
         */
        $categorias = [
            ['slug' => 'cabelo',    'nome' => 'Cabelo',          'icone' => 'bi-scissors',   'tom' => 'vinho',
             'desc' => 'Do corte à coloração, com cuidado em cada fio.',
             'itens' => ['Corte', 'Coloração', 'Botox capilar', 'Escova'],
             'preco' => 'A partir de R$150', 'tempo' => '60 min',
             'fotos' => ['mulher-cortando-o-cabelo-no-salao-de-beleza_23-2149167396.jpg']],

            ['slug' => 'manicure',  'nome' => 'Manicure',        'icone' => 'bi-gem',        'tom' => 'rose',
             'desc' => 'Cutilagem cuidadosa e esmaltação tradicional ou em gel.',
             'itens' => ['Cutilagem', 'Esmaltação', 'Gel'],
             'preco' => 'A partir de R$45', 'tempo' => '45 min',
             'fotos' => ['manicure.png']],

            ['slug' => 'pedicure',  'nome' => 'Pedicure',        'icone' => 'bi-flower1',    'tom' => 'areia',
             'desc' => 'Pés macios, unhas alinhadas e esmaltação perfeita.',
             'itens' => ['Cutilagem', 'Esfoliação', 'Esmaltação'],
             'preco' => null, 'tempo' => null, 'fotos' => []],

            ['slug' => 'massagem',  'nome' => 'Massagem',        'icone' => 'bi-peace',      'tom' => 'vinho',
             'desc' => 'Um momento para desacelerar e relaxar o corpo.',
             'itens' => ['Relaxante', 'Modeladora'],
             'preco' => null, 'tempo' => null, 'fotos' => []],

            ['slug' => 'limpeza-de-pele', 'nome' => 'Limpeza de pele', 'icone' => 'bi-droplet', 'tom' => 'rose',
             'desc' => 'Pele renovada, hidratada e com viço de verdade.',
             'itens' => ['Higienização', 'Extração', 'Hidratação'],
             'preco' => null, 'tempo' => null, 'fotos' => []],

            ['slug' => 'maquiagem', 'nome' => 'Maquiagem',       'icone' => 'bi-brush',      'tom' => 'areia',
             'desc' => 'Produção para o dia a dia, festas e grandes ocasiões.',
             'itens' => ['Social', 'Festa', 'Noivas'],
             'preco' => null, 'tempo' => null, 'fotos' => []],

            ['slug' => 'depilacao', 'nome' => 'Depilação',       'icone' => 'bi-stars',      'tom' => 'vinho',
             'desc' => 'Depilação com cera quente para pele lisa e duradoura.',
             'itens' => ['Cera quente', 'Corpo todo'],
             'preco' => 'A partir de R$20', 'tempo' => '40 min',
             'fotos' => ['depilacao.png']],
        ];

        foreach ($categorias as $i => $c) {
            $categorias[$i]['foto'] = null;
            foreach (array_merge(['servicos/'.$c['slug'].'.jpg'], $c['fotos']) as $f) {
                if (file_exists(public_path('images/'.$f))) { $categorias[$i]['foto'] = $f; break; }
            }
        }

        /* paleta de tons (nível de cor / nome / arquivo em public/images/mechas/tom-<arquivo>.jpg) */
        $tons = [
            ['1.0',  'Preto',       '1-0'],
            ['3.0',  'Castanho escuro', '3-0'],
            ['5.0',  'Castanho',    '5-0'],
            ['5.7',  'Chocolate',   '5-7'],
            ['6.6',  'Vermelho',    '6-6'],
            ['7.4',  'Acobreado',   '7-4'],
            ['7.3',  'Dourado',     '7-3'],
            ['8.0',  'Louro claro', '8-0'],
            ['10.1', 'Platinado',   '10-1'],
            ['9.2',  'Rosé',        '9-2'],
        ];
    @endphp

    <main class="sv-pagina">

        {{-- ================= BANNER (igual ao da página de produtos) ================= --}}
        <section class="sv-banner">
            <div class="sv-miolo sv-banner-grade">

                <div class="sv-banner-texto">
                    <nav class="sv-trilha" aria-label="Você está em">
                        <a href="{{ route('home') }}">Início</a>
                        <span aria-hidden="true">/</span>
                        <span>Serviços</span>
                    </nav>

                    <h1>Nossos serviços</h1>

                    <p>Cabelo, unhas, pele e bem-estar em um só lugar, com excelência, cuidado e autoestima.</p>

                    <div class="sv-banner-acoes">
                        <a href="{{ route('agendamento.agendar') }}" class="sv-btn sv-btn-vinho">Agendar agora</a>
                        <a href="{{ route('site.produtos') }}" class="sv-btn sv-btn-borda">Confira nossos produtos</a>
                    </div>
                </div>

                <div class="sv-banner-foto">
                    <img src="{{ asset('images/servicos-banner.png') }}" alt="Cliente de costas mostrando o cabelo feito no salão">
                </div>

            </div>
        </section>


        {{-- ================= CARROSSEL ================= --}}
        <section class="sv-carrossel-secao" aria-labelledby="sv-titulo-categorias">
            <div class="sv-miolo">

                <header class="sv-secao-topo">
                    <div>
                        <span class="sv-sobretitulo">O que oferecemos</span>
                        <h2 id="sv-titulo-categorias">Escolha uma categoria</h2>
                    </div>
                </header>

            </div>

            <div class="sv-carrossel" id="sv-carrossel">
                <button type="button" class="sv-seta" id="sv-anterior" aria-label="Anterior"><i class="bi bi-arrow-left"></i></button>
                <button type="button" class="sv-seta" id="sv-proximo" aria-label="Próximo"><i class="bi bi-arrow-right"></i></button>
                <div class="sv-trilho" id="sv-trilho" tabindex="0" aria-label="Categorias de serviços (arraste para o lado)">

                    @foreach($categorias as $i => $c)
                        <article class="sv-card sv-tom-{{ $c['tom'] }}">

                            <div class="sv-card-midia">
                                @if($c['foto'])
                                    <img src="{{ asset('images/'.$c['foto']) }}" alt="{{ $c['nome'] }}" draggable="false">
                                @else
                                    <div class="sv-card-icone"><i class="bi {{ $c['icone'] }}"></i></div>
                                @endif

                                <span class="sv-card-numero">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>

                            <div class="sv-card-corpo">
                                <h3>{{ $c['nome'] }}</h3>
                                <p>{{ $c['desc'] }}</p>

                                <ul class="sv-chips">
                                    @foreach($c['itens'] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>

                                <div class="sv-card-rodape">
                                    <div class="sv-card-preco">
                                        @if($c['preco'])
                                            <strong>{{ $c['preco'] }}</strong>
                                            <small>{{ $c['tempo'] }}</small>
                                        @else
                                            <strong>Consulte valores</strong>
                                            <small>No agendamento</small>
                                        @endif
                                    </div>

                                    <a href="{{ route('agendamento.agendar') }}" class="sv-card-ir" aria-label="Agendar {{ $c['nome'] }}">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach

                </div>
            </div>

            <div class="sv-miolo">
                <div class="sv-pontos" id="sv-pontos" role="tablist" aria-label="Posição no carrossel"></div>
            </div>
        </section>


        {{-- ================= PALETA DE TONS (fotos de mechas) ================= --}}
        <section class="sv-paleta-secao" aria-labelledby="sv-titulo-paleta">
            <div class="sv-miolo">

                <header class="sv-secao-centro">
                    <span class="sv-sobretitulo">Coloração</span>
                    <h2 id="sv-titulo-paleta">Encontre o seu tom</h2>
                    <p>Do castanho profundo ao louro platinado: toque em um tom e leve a referência para o seu horário.</p>
                </header>

                <ul class="sv-paleta" id="sv-paleta">
                    @foreach($tons as $t)
                        <li>
                            <button type="button" class="sv-tom" data-nivel="{{ $t[0] }}" data-nome="{{ $t[1] }}" aria-label="Tom {{ $t[0] }} {{ $t[1] }}">
                                <span class="sv-tom-circulo">
                                    <img src="{{ asset('images/mechas/tom-'.$t[2].'.jpg') }}" alt="Mecha de cabelo tom {{ $t[1] }}" loading="lazy" draggable="false">
                                </span>
                                <span class="sv-tom-nivel">{{ $t[0] }}</span>
                                <span class="sv-tom-nome">{{ $t[1] }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>

                <p class="sv-paleta-escolhido" id="sv-paleta-escolhido" data-agendar="{{ route('agendamento.agendar') }}" aria-live="polite">Selecione um tom da paleta.</p>

            </div>
        </section>


        {{-- ================= COMO AGENDAR ================= --}}
        <section class="sv-passos-secao">
            <div class="sv-miolo">

                <header class="sv-secao-centro">
                    <span class="sv-sobretitulo">Simples assim</span>
                    <h2>Como agendar</h2>
                </header>

                <ol class="sv-passos">
                    <li>
                        <span class="sv-passo-num">1</span>
                        <h3>Escolha o serviço</h3>
                        <p>Veja as categorias e decida o que combina com você.</p>
                    </li>
                    <li>
                        <span class="sv-passo-num">2</span>
                        <h3>Marque seu horário</h3>
                        <p>Selecione o dia e o horário disponíveis na agenda do salão.</p>
                    </li>
                    <li>
                        <span class="sv-passo-num">3</span>
                        <h3>Aproveite o momento</h3>
                        <p>É só chegar e se cuidar. O resto fica com a gente.</p>
                    </li>
                </ol>

            </div>
        </section>


        {{-- ================= CTA: SIMULAR O LOOK ================= --}}
        <section class="sv-miolo">
            <div class="sv-cta">
                <div class="sv-cta-brilhos" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/></svg><svg viewBox="0 0 24 24"><path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/></svg><svg viewBox="0 0 24 24"><path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/></svg><svg viewBox="0 0 24 24"><path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/></svg>
                </div>
                <div class="sv-cta-estrela" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/>
                        <path class="peq" d="M19.5 1c.2 2 1.6 3.4 3.5 3.5-1.9.2-3.3 1.6-3.5 3.5-.2-1.9-1.6-3.3-3.5-3.5 1.9-.1 3.3-1.5 3.5-3.5Z" fill="currentColor" transform="translate(1 -1)"/>
                        <path class="peq peq2" d="M4.5 16c.2 1.6 1.4 2.8 3 3-1.6.2-2.8 1.4-3 3-.2-1.6-1.4-2.8-3-3 1.6-.2 2.8-1.4 3-3Z" fill="currentColor" transform="translate(-1 1)"/>
                    </svg>
                </div>
                <span class="sv-sobretitulo sv-sobretitulo-claro">Em dúvida sobre o visual?</span>
                <h2>Simule seu corte, cor ou unha</h2>
                <p>Experimente com nossa IA e depois marque o seu horário.</p>

                <div class="sv-banner-acoes sv-cta-acoes">
                    <a href="{{ route('site.ia') }}" class="sv-btn sv-btn-claro"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1.5c.5 5.6 4.9 10 10.5 10.5-5.6.5-10 4.9-10.5 10.5C11.5 16.9 7.1 12.5 1.5 12 7.1 11.5 11.5 7.1 12 1.5Z" fill="currentColor"/></svg>Simular meu look</a>
                    <a href="{{ route('agendamento.agendar') }}" class="sv-btn sv-btn-contorno">Agendar agora</a>
                </div>
            </div>
        </section>

    </main>

    @include('components.footer')

    <script src="{{ asset('js/servicos.js') }}"></script>

@endsection
