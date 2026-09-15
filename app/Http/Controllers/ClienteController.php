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
                'unique:cliente,cpf'
            ],

            'telefone' => [
                'required_without:email',
                'nullable',
                'digits:11',
                'unique:cliente,telefone'
            ],

            'email' => [
                'required_without:telefone',
                'nullable',
                'email',
                'max:255',
                'unique:cliente,email'
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

        $validated = $validator->validated();

        $validated['senha'] = Hash::make($validated['senha']);

        $cliente = ClienteModel::create($validated);

        Auth::login($cliente);

        $request->session()->regenerate();

        return redirect()->route('site.sobre');
    }

    public function editCliente(string $id)
    {
        $cliente = ClienteModel::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    public function updateCliente(Request $request, $id)
    {
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
                Rule::unique('cliente', 'cpf')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'telefone' => [
                'required_without:email',
                'nullable',
                'digits:11',
                Rule::unique('cliente', 'telefone')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'email' => [
                'required_without:telefone',
                'nullable',
                'email',
                'max:255',
                Rule::unique('cliente', 'email')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'data_nascimento' => [
                'required',
                'date'
            ],

            'senha' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
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

        return redirect()
            ->route('site.sobre')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroyCliente(string $id)
    {
        ClienteModel::destroy($id);

        return redirect()->route('cliente.cadastro');
    }

    public function loginCliente()
    {
        return view('cliente.login');
    }

    public function authCliente(Request $request)
    {
        $auth = $request->auth;

        $cliente = ClienteModel::where('email', $auth)
            ->orWhere('telefone', $auth)
            ->first();

        if (!$cliente || !Hash::check($request->senha, $cliente->senha)) {
            return back()
                ->with('erro', 'E-mail/Telefone ou senha inválidos.');
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

    public function viewPerfilCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

        return view('cliente.perfil', compact('cliente'));
    }

    public function editPerfil()
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

        return view('cliente.update', compact('cliente'));
    }

    public function updatePerfil(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

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
                Rule::unique('cliente', 'cpf')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'telefone' => [
                'required_without:email',
                'nullable',
                'digits:11',
                Rule::unique('cliente', 'telefone')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'email' => [
                'required_without:telefone',
                'nullable',
                'email',
                'max:255',
                Rule::unique('cliente', 'email')
                    ->ignore($cliente->cliente_id, 'cliente_id')
            ],

            'data_nascimento' => [
                'required',
                'date'
            ],

            'senha' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
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

        return redirect()
            ->route('cliente.perfil')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}