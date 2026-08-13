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
use Illuminate\Support\Facades\Auth;


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
                'max:11',
                'min:11'

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

        return redirect()->route('site.sobre');
    }

    

    function editCliente(string $id){
        $cliente = Cliente::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    function updateCliente(Request $dados, $id) {
        $cliente = Cliente::findOrFail($id);

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
                'max:11',
                'min:11',
                Rule::unique('cliente', 'cpf')->ignore($cliente->id)

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
            'nullable',
            Password::min(8)->letters()->mixedCase()->numbers()->symbols()
        ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('cliente.cadastro')
                ->withErrors($validator)
                ->withInput();
        }

        if (!empty($validated['senha'])) {
            $validated['senha'] = Hash::make($validated['senha']);
        } else {
            unset($validated['senha']);
        }

        $validated = $validator->validated();

        return redirect()->route('site.home');
    }


    function destroyCliente(string $id) {
            Cliente::destroy($id);
            return redirect()->route('cliente.cadastro');
        }

        function loginCliente(){
            return view('cliente.login');
        }
    
            public function authCliente(Request $request)
        {

            $auth = $request->auth;

            $cliente = Cliente::where('email', $auth)
                ->orWhere('telefone', $auth)
                ->first();
    
            if (!$cliente) {
                return back()->with('erro', 'E-mail/Telefone ou senha inválidos.');
            }
    
            if (!Hash::check($request->senha, $cliente->senha)) {
                return back()->with('erro', 'E-mail/Telefone ou senha inválidos.');
            }


    
            session([
                'cliente_id' => $cliente->cliente_id,
                'admin' => $cliente->admin,
            ]);
            
            return redirect()->route('site.sobre');
        }
    
            public function logoutCliente()
        {
            session()->flush();
    
            return redirect()->route('cliente.login');
        }
    
}


