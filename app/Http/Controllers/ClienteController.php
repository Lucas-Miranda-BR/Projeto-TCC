<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    /* ===========================
       PÁGINAS
    ============================*/

    public function dashboard()
    {
        if (!session()->has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        return view('cliente.dashboard');
    }

    public function perfil()
    {
        if (!session()->has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        return view('cliente.perfil');
    }

    public function agendamentos()
    {
        if (!session()->has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        return view('cliente.agendamentos');
    }

    public function login()
    {
        return view('cliente.login');
    }

    public function cadastro()
    {
        return view('cliente.cadastro');
    }

    /* ===========================
       CADASTRO
    ============================*/

    public function salvarCadastro(Request $request)
    {

        $request->validate([

            'nome' => 'required|max:100',
            'sobrenome' => 'required|max:100',
            'cpf' => 'required|unique:cliente,cpf',
            'telefone' => 'required',
            'email' => 'required|email|unique:cliente,email',
            'endereco' => 'required',
            'data_nascimento' => 'required|date',
            'senha' => 'required|min:6|confirmed',

            'estado_id' => 'required',
            'cidade_id' => 'required',

        ],[

            'nome.required' => 'Informe o nome.',

            'sobrenome.required' => 'Informe o sobrenome.',

            'cpf.required' => 'Informe o CPF.',

            'cpf.unique' => 'Este CPF já está cadastrado.',

            'telefone.required' => 'Informe o telefone.',

            'email.required' => 'Informe o e-mail.',

            'email.email' => 'Digite um e-mail válido.',

            'email.unique' => 'Este e-mail já está cadastrado.',

            'endereco.required' => 'Informe o endereço.',

            'data_nascimento.required' => 'Informe a data de nascimento.',

            'senha.required' => 'Informe uma senha.',

            'senha.min' => 'A senha deve possuir no mínimo 6 caracteres.',

            'senha.confirmed' => 'As senhas não conferem.'

        ]);

        Cliente::create([

            'nome' => $request->nome,

            'sobrenome' => $request->sobrenome,

            'cpf' => $request->cpf,

            'telefone' => $request->telefone,

            'email' => $request->email,

            'endereco' => $request->endereco,

            'data_nascimento' => $request->data_nascimento,

            'estado_id' => $request->estado_id,

            'cidade_id' => $request->cidade_id,

            'admin' => false,

            'senha' => Hash::make($request->senha)

        ]);

        return redirect()
            ->route('cliente.login')
            ->with('sucesso', 'Cadastro realizado com sucesso! Faça seu login.');

    }

    /* ===========================
       LOGIN
    ============================*/

    public function entrar(Request $request)
    {

        $request->validate([

            'email' => 'required|email',

            'senha' => 'required'

        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente) {

            return back()

                ->withInput()

                ->with('erro', 'E-mail não cadastrado.');

        }

        if (!Hash::check($request->senha, $cliente->senha)) {

            return back()

                ->withInput()

                ->with('erro', 'Senha incorreta.');

        }

        session([

            'cliente_id' => $cliente->cliente_id,

            'cliente_nome' => $cliente->nome,

            'cliente_email' => $cliente->email,

            'cliente_admin' => $cliente->admin

        ]);

        return redirect()->route('cliente.dashboard');

    }

    /* ===========================
       LOGOUT
    ============================*/

    public function sair()
    {

        session()->flush();

        return redirect()

            ->route('cliente.login')

            ->with('sucesso', 'Logout realizado com sucesso.');

    }
}