<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClienteController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | CADASTRO
    |--------------------------------------------------------------------------
    */

    public function createCliente()
    {
        return view('cliente.cadastro');
    }


    public function storeCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                'nullable',
                'digits:11',
                'unique:cliente',
                'max:11',
                'min:11'
            ],
            
            'telefone' => [
                'required_without:email',
                'digits:11',
                'unique:cliente',
                'min:11',
                'max:11',
                'nullable'
            ],

            'email' => [
                'required_without:telefone',
                'email',
                'max:255',
                'nullable',
                'unique:cliente'
            ],
                        
            'data_nascimento' => [
                'date',
                'required'
            ],
            
            'senha' => [
                'required',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
            
        ]);


        if ($validator->fails()) {

            return redirect()
                ->route('cliente.cadastro')
                ->withErrors($validator)
                ->withInput();

        }


        $dados = $validator->validated();


        $dados['senha'] = Hash::make(
            $dados['senha']
        );


        $cliente = ClienteModel::create($dados);


        session([
            'cliente' => $cliente
        ]);


        Auth::login($cliente);


        return redirect()
            ->route('site.sobre');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function loginCliente()
    {
        return view('cliente.login');
    }


        $validator = Validator::make($request->all(), [
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
                'nullable',
                'digits:11',
                Rule::unique('cliente')->ignore($cliente->cliente_id, 'cliente_id'),
            ],
            
            'telefone' => [
                'required_without:email',
                'digits:11',
                Rule::unique('cliente')->ignore($cliente->cliente_id, 'cliente_id'),
                'nullable'
            ],

            'email' => [
                'required_without:telefone',
                'email',
                'max:255',
                'nullable',
                Rule::unique('cliente')->ignore($cliente->cliente_id, 'cliente_id')
            ],
                            
            'data_nascimento' => [
                'date',
                'required'
            ],
            
            'senha' => [
                'nullable',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],

        ]);


        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();

        }


        $dados = $validator->validated();

        $cliente->update($validated);

        return redirect()->route('site.home')->with('success', 'Perfil atualizado com sucesso!');
    }


    /*
    |--------------------------------------------------------------------------
    | ALTERAR SENHA
    |--------------------------------------------------------------------------
    */

    public function updateSenha(Request $request)
    {
        $clienteSession = session('cliente');


        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login');

        }


        $cliente = ClienteModel::findOrFail(
            $clienteSession->cliente_id
        );


        $request->validate([

            'senha_atual' => [
                'required'
            ],

            'senha' => [
                'required',
                'confirmed',

                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]

        ]);


        if (!Hash::check(
            $request->senha_atual,
            $cliente->senha
        )) {

            return back()
                ->withErrors([
                    'senha_atual' => 'A senha atual está incorreta.'
                ]);

        }
    
        public function authCliente(Request $request)
        {
            $auth = $request->auth;
        
            $cliente = ClienteModel::where('email', $auth)
                ->orWhere('telefone', $auth)
                ->first();
        
            if (!$cliente || !Hash::check($request->senha, $cliente->senha)) {
                return back()->with('erro', 'E-mail/Telefone ou senha inválidos.');
            }
        
            Auth::login($cliente);
            
            $request->session()->regenerate();
        
            if ($cliente->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('site.sobre');
        }
    
        public function logoutCliente(Request $request)
        {
            Auth::logout();
        
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        
            return redirect()->route('cliente.login');
        }
        
            public function viewPerfilCliente(){
                return view('cliente.perfil');
            }
}


        session()->flush();


        return redirect()
            ->route('home');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logoutCliente(Request $request)
    {
        $request->session()->forget('cliente');

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('cliente.login');
    }

}