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
                'min:2',
                'max:100'
            ],

            'sobrenome' => [
                'required',
                'string',
                'min:2',
                'max:100'
            ],

            'cpf' => [
                'required',
                'digits:11',
                'unique:cliente,cpf'
            ],

            'telefone' => [
                'nullable',
                'required_without:email',
                'digits:11',
                'unique:cliente,telefone'
            ],

            'email' => [
                'nullable',
                'required_without:telefone',
                'email',
                'max:255',
                'unique:cliente,email'
            ],

            'cep' => [
                'nullable',
                'string',
                'max:9'
            ],

            'endereco' => [
                'nullable',
                'string',
                'max:255'
            ],

            'data_nascimento' => [
                'required',
                'date'
            ],

            'senha' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]

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


        $request->session()->regenerate();


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


    public function authCliente(Request $request)
    {
        $request->validate([

            'auth' => [
                'required',
                'string'
            ],

            'senha' => [
                'required',
                'string'
            ]

        ]);


        $auth = $request->auth;


        $cliente = ClienteModel::where('email', $auth)
            ->orWhere('telefone', $auth)
            ->first();


        if (!$cliente) {

            return back()
                ->with('erro', 'E-mail/Telefone ou senha inválidos.')
                ->withInput();

        }


        if (!Hash::check($request->senha, $cliente->senha)) {

            return back()
                ->with('erro', 'E-mail/Telefone ou senha inválidos.')
                ->withInput();

        }


        $request->session()->regenerate();


        session([
            'cliente' => $cliente
        ]);


        return redirect()
            ->route('site.sobre');
    }


    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    public function perfil()
    {
        $clienteSession = session('cliente');


        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login para acessar seu perfil.');

        }


        $cliente = ClienteModel::find(
            $clienteSession->cliente_id
        );


        if (!$cliente) {

            session()->forget('cliente');


            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Cliente não encontrado. Faça login novamente.');

        }


        return view(
            'cliente.perfil',
            compact('cliente')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR PERFIL
    |--------------------------------------------------------------------------
    */

    public function editPerfil()
    {
        $clienteSession = session('cliente');


        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login para editar seu perfil.');

        }


        $cliente = ClienteModel::find(
            $clienteSession->cliente_id
        );


        if (!$cliente) {

            session()->forget('cliente');


            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Cliente não encontrado. Faça login novamente.');

        }


        return view(
            'cliente.editar-perfil',
            compact('cliente')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ATUALIZAR PERFIL
    |--------------------------------------------------------------------------
    */

    public function updatePerfil(Request $request)
    {
        $clienteSession = session('cliente');


        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login para alterar seu perfil.');

        }


        $cliente = ClienteModel::find(
            $clienteSession->cliente_id
        );


        if (!$cliente) {

            session()->forget('cliente');


            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Cliente não encontrado.');

        }


        $validator = Validator::make($request->all(), [

            'nome' => [
                'required',
                'string',
                'min:2',
                'max:100'
            ],

            'sobrenome' => [
                'required',
                'string',
                'min:2',
                'max:100'
            ],

            'email' => [
                'nullable',
                'required_without:telefone',
                'email',
                'max:255',

                Rule::unique('cliente', 'email')
                    ->ignore(
                        $cliente->cliente_id,
                        'cliente_id'
                    )
            ],

            'telefone' => [
                'nullable',
                'required_without:email',
                'digits:11',

                Rule::unique('cliente', 'telefone')
                    ->ignore(
                        $cliente->cliente_id,
                        'cliente_id'
                    )
            ],

            'cep' => [
                'nullable',
                'string',
                'max:9'
            ],

            'endereco' => [
                'nullable',
                'string',
                'max:255'
            ],

            'data_nascimento' => [
                'required',
                'date'
            ]

        ]);


        if ($validator->fails()) {

            return redirect()
                ->route('cliente.perfil.editar')
                ->withErrors($validator)
                ->withInput();

        }


        $dados = $validator->validated();


        $cliente->update($dados);


        $cliente->refresh();


        session([
            'cliente' => $cliente
        ]);


        return redirect()
            ->route('cliente.perfil')
            ->with(
                'success',
                'Perfil atualizado com sucesso!'
            );
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


        $cliente->senha = Hash::make(
            $request->senha
        );


        $cliente->save();


        return back()
            ->with(
                'success',
                'Senha alterada com sucesso!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EXCLUIR CONTA
    |--------------------------------------------------------------------------
    */

    public function destroyCliente()
    {
        $clienteSession = session('cliente');


        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login');

        }


        $cliente = ClienteModel::find(
            $clienteSession->cliente_id
        );


        if ($cliente) {
            $cliente->delete();
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