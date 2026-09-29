@foreach ($produtos as $produto)
    <div class="produto-card">
        
        <div class="produto-imagem">
            <img src="{{ asset('images/produtos/' . $produto->foto) }}" alt="{{ $produto->nome }}">
            
            @if($produto->desconto_ativo)
                <span class="badge-desconto" style="position: absolute; top: 10px; right: 10px; background: #ffc107; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.85rem;">
                    -{{ $produto->desconto_ativo->valor }}%
                </span>
            @endif
        </div>

        <div class="produto-info">
            <h3>{{ $produto->nome }}</h3>

            @if($produto->desconto_ativo)
                <div class="preco-container" style="display: flex; flex-direction: column; gap: 2px;">
                    <small style="text-decoration: line-through; color: #999;">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </small>
                    <strong style="color: #28a745; font-size: 1.2rem;">
                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                    </strong>
                    
                    @if($produto->desconto_ativo->quando_terminar)
                        <small style="color: #dc3545; font-size: 0.75rem;">
                            Termina: {{ \Carbon\Carbon::parse($produto->desconto_ativo->quando_terminar)->format('d/m') }}
                        </small>
                    @endif
                </div>
            @else
                <div class="preco-container">
                    <strong style="font-size: 1.2rem;">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </strong>
                </div>
            @endif

        </div>

        <div class="produto-bottom">
            @if ($produto->estoque >= 1)
                
                @auth
                    <form
                        action="{{ route('carrinho.adicionar', $produto->item_id) }}"
                        method="POST"
                        class="produto-compra-form"
                    >
                        @csrf
                        <div class="quantidade-produto">
                            <button type="button" class="quantidade-btn quantidade-menos" title="Diminuir quantidade">
                                <i class="bi bi-dash"></i>
                            </button>
                            
                            <input type="number" name="quantidade" class="quantidade-input" value="1" min="1" max="{{ $produto->estoque }}" readonly>
                            
                            <button type="button" class="quantidade-btn quantidade-mais" title="Aumentar quantidade">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn-adicionar" title="Adicionar ao carrinho">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('cliente.login') }}" style="width: 100%; display: flex; text-decoration: none;">
                        <button type="button" class="btn-adicionar" style="width: 100%; border-radius: 8px; font-size: 0.9rem; justify-content: center; display: flex; align-items: center; gap: 8px;" title="Faça login para comprar">
                            <i class="bi bi-box-arrow-in-right"></i> Fazer Login
                        </button>
                    </a>
                @endauth

            @else
                <button type="button" class="btn-adicionar btn-esgotado" disabled title="Produto esgotado" style="width: 100%; justify-content: center; display: flex;">
                    <i class="bi bi-bag-x"></i> Esgotado
                </button>
            @endif
        </div>

    </div>
@endforeach