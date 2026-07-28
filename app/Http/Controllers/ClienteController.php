<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    function createCliente(){
        return view('cliente.cadastro');
    }

    function storeCliente(Request $dados){
        $validator = Validator::make($dados->all(), [
            'nome' => [
                'required',
                'string',
                'min:2'
            ],

            'sobrenome' => [
                'required',
                'string',
                'min:2'
            ],
            'cpf' => [
                'required',
                'string',
                'unique:cliente',
                'max:11'

            ],
            'telefone' => [
            'required_without:email',
            'string',
            'unique:cliente',
            'max:11',
            'nullable'
        ],

            'email' => [
                'required_without:telefone',
                'email',
                'max:255',
                'nullable'
        ],
        'endereco' => [
            'string',
            'required'
        ],
        'data_nascimento' => [
            'date',
            'required'
        ],
        'senha' => [
            'required',
            Password::min(8)->letters()->mixedCase()->numbers()->symbols()
        ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('cliente.cadastro')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        Cliente::create($validated);

        return redirect()->route('site.home');
    }

    

    function editCliente(string $id){
        $cliente = Cliente::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    function updateCliente(Request $dados, $id) {
        $cliente = Cliente::findOrFail($id);

        $validated = $dados->validate([
            'nome' => [
                'required',
                'string',
                'min:2'
            ],

            'sobrenome' => [
                'required',
                'string',
                'min:2'
            ],
            'cpf' => [
                'required',
                'string',
                'unique:cliente',
                'max:11'

            ],
            'telefone' => [
            'required_without:email',
            'string',
            'unique:cliente',
            'max:11',
            'nullable',
            Rule::unique('cliente', 'telefone')->ignore($cliente->id)
        ],

            'email' => [
                'required_without:telefone',
                'email',
                'max:255',
                'nullable'
        ],
        'endereco' => [
            'string',
            'required'
        ],
        'data_nascimento' => [
            'date',
            'required'
        ],
        'senha' => [
            'required',
            Password::min(8)->letters()->mixedCase()->numbers()->symbols()
        ]
        ]);

        $cliente->update($validated);

        return redirect()->route('site.home');
    }

    function destroyCliente(string $id) {
            Cliente::destroy($id);
            return redirect()->route('cliente.cadastro');
        }

        function loginCliente(){
            return view('cliente.login');
        }
    
            public function autenticar(Request $request)
        {
            $cliente = Cliente::where('email', $request->email)->first();
            if ($cliente == null) {
                $cliente = Cliente::where('telefone', $request->telefone)->first();
            }
    
            if (!$cliente) {
                return back()->with('erro', 'E-mail/Telefone ou senha inválidos.');
            }
    
            if (!Hash::check($request->senha, $cliente->senha)) {
                return back()->with('erro', 'E-mail/Telefone ou senha inválidos.');
            }
    
            session([
                'cliente_id' => $cliente->cliente_id,
                'nome' => $cliente->nome,
                'sobrenome' => $cliente->sobrenome,
                'cpf' => $cliente->cpf,
                'telefone' => $cliente->telefone,
                'email' => $cliente->email,
                'endereco' => $cliente->endereco,
                'data_nascimento' => $cliente->data_nascimento,
                'admin' => $cliente->admin,
            ]);
    
            return redirect()->route('principal');
        }
    
            public function logoutCliente()
        {
            session()->flush();
    
            return redirect()->route('principal');
        }
    
}


