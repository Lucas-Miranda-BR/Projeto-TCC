<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ProcedimentoModel;
use App\Models\CorModel;
use App\Models\ItemModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;

class SiteController extends Controller
{
    public function viewHome()
    {
        return view('home');
    }

    public function viewSobre()
    {
        return view('site.sobre');
    }

    public function viewServicos()
    {
        return view('site.servicos');
    }

    public function viewIa()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('cliente.cadastro')
                ->withErrors([
                    'Por favor realize um cadastro ou entre em uma conta para utilizar nossos recursos de IA.'
                ]);
        }

        $procedimentos = ProcedimentoModel::with('tipos')->get();

        $cores = CorModel::all();

        $cliente = Auth::user();

        return view(
            'site.ia',
            compact(
                'procedimentos',
                'cliente',
                'cores'
            )
        );
    }

    public function viewProdutos(Request $request)
    {
        $query = ItemModel::with([
            'categorias',
            'marcas'
        ]);

        if ($request->filled('busca')) {
            $busca = trim($request->busca);

            $query->where(
                'nome',
                'like',
                '%' . $busca . '%'
            );
        }

        if ($request->filled('categoria')) {
            $query->where(
                'categoria_id',
                $request->categoria
            );
        }

        if ($request->filled('marca')) {
            $query->where(
                'marca_id',
                $request->marca
            );
        }

        $produtos = $query
            ->orderBy('nome', 'asc')
            ->paginate(9)
            ->withQueryString();

        $categorias = CategoriaModel::orderBy('nome', 'asc')
            ->get();

        $marcas = MarcaModel::orderBy('nome', 'asc')
            ->get();

        return view(
            'site.produtos',
            compact(
                'produtos',
                'categorias',
                'marcas'
            )
        );
    }

    public function viewProdutoDetalhe($id)
    {
        $item = \App\Models\ItemModel::with(['marcas', 'categorias'])->findOrFail($id);
        
        $carrinho = session()->get('carrinho', []);
        $quantidadeNoCarrinho = $carrinho[$id] ?? 0;

        return view('site.produto-detalhe', compact('item', 'quantidadeNoCarrinho'));
    }
}