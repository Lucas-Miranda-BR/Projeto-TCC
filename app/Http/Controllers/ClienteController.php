<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Models\ClienteModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    function createCliente(){
        return view('cliente.cadastro');
    }

    function storeCliente(Request $request){
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

        $validated = $validator->validated();

        $cliente = ClienteModel::create($validated);

        Auth::login($cliente);

        return redirect()->route('site.sobre');
    }

    function editCliente(string $id){
        $cliente = ClienteModel::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    function updateCliente(Request $request, $id) {
        $cliente = ClienteModel::findOrFail($id);

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

        $validated = $validator->validated();

        if (!empty($validated['senha'])) {
            $validated['senha'] = Hash::make($validated['senha']);
        } else {
            unset($validated['senha']);
        }

        $cliente->update($validated);

        return redirect()->route('site.home')->with('success', 'Perfil atualizado com sucesso!');
    }

    function destroyCliente(string $id) {
            ClienteModel::destroy($id);
            return redirect()->route('cliente.cadastro');
        }

        function loginCliente(){
            return view('cliente.login');
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


