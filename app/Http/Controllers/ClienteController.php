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
            'nome' => ['required','string','min:2'],

            'sobrenome' => ['required','string','min:2'],
            
            'cpf' => ['required','string','unique:cliente','max:11','min:11'],
            
            'telefone' => ['required_without:email','string','unique:cliente','min:11','max:11','nullable'],

            'email' => ['required_without:telefone','email','max:255','nullable','unique:cliente',],
                        
            'data_nascimento' => ['date','required'],
            
            'senha' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            
        ],
        [
            'nome.required' => 'O campo nome é necessário.',
            'nome.min' => 'O nome precisa ter pelo menos 2 caracteres.',
            
            'sobrenome.required' => 'O campo sobrenome é necessário.',
            'sobrenome.min' => 'O sobrenome precisa ter pelo menos 2 caracteres.',
            
            'cpf.required' => 'O CPF é necessário.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'cpf.max' => 'O CPF deve conter exatamente 11 números.',
            'cpf.min' => 'O CPF deve conter exatamente 11 números.',
            
            'telefone.required_without' => 'Informe o telefone ou o e-mail para contato.',
            'telefone.unique' => 'Este número de telefone já está cadastrado.',
            'telefone.min' => 'O telefone deve ter 11 caracteres (com DDD).',
            'telefone.max' => 'O telefone deve ter 11 caracteres (com DDD).',
            
            'email.required_without' => 'Informe o e-mail ou o telefone para contato.',
            'email.email' => 'Digite um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
                        
            'data_nascimento.required' => 'A data de nascimento é necessária.',
            'data_nascimento.date' => 'Insira uma data de nascimento válida.',
            
            'senha.required' => 'A senha é necessária.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('cliente.cadastro')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $cliente = Cliente::create($validated);

        session(['cliente' => $cliente]);

        return redirect()->route('site.sobre');
    }

    function editCliente(string $id){
        $cliente = Cliente::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    function updateCliente(Request $dados, $id) {
        $cliente = Cliente::findOrFail($id);

        $validator = Validator::make($dados->all(), [
            'nome' => ['required', 'string', 'min:2'],

            'sobrenome' => ['required','string','min:2'],

            'cpf' => ['required','string','unique:cliente','max:11','min:11',Rule::unique('cliente', 'cpf')->ignore($cliente->id)],
            
            'telefone' => ['required_without:email','string','unique:cliente','max:11','min:11','nullable',Rule::unique('cliente', 'telefone')->ignore($cliente->id)],
            
            'email' => ['required_without:telefone','unique:cliente','email','max:255','nullable',Rule::unique('cliente', 'email')->ignore($cliente->id)],

            'endereco' => ['string','required'],

            'data_nascimento' => ['date','required'],

            'senha' => ['nullable',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],

            'cep' => ['required','string','max:8','min:8']
        ],
        [
            'nome.required' => 'O campo nome é necessário.',
            'nome.min' => 'O nome precisa ter pelo menos 2 caracteres.',

            'sobrenome.required' => 'O campo sobrenome é necessário.',
            'sobrenome.min' => 'O sobrenome precisa ter pelo menos 2 caracteres.',

            'cpf.required' => 'O CPF é necessário.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'cpf.max' => 'O CPF deve conter exatamente 11 números.',
            'cpf.min' => 'O CPF deve conter exatamente 11 números.',
            
            'telefone.required_without' => 'Informe o telefone ou o e-mail para contato.',
            'telefone.unique' => 'Este número de telefone já está cadastrado.',
            'telefone.min' => 'O telefone deve ter 11 caracteres (com DDD).',
            'telefone.max' => 'O telefone deve ter 11 caracteres (com DDD).',
            
            'email.required_without' => 'Informe o e-mail ou o telefone para contato.',
            'email.email' => 'Digite um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            
            'endereco.required' => 'O endereço é necessário.',
            
            'data_nascimento.required' => 'A data de nascimento é necessária.',
            'data_nascimento.date' => 'Insira uma data de nascimento válida.',
            
            'senha.required' => 'A senha é necessária.',
            
            'cep.required' => 'O CEP é necessário.',
            'cep.max' => 'O CEP deve ter 8 caracteres.',
            'cep.min' => 'O CEP deve ter 8 caracteres.'
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

        $cliente->update($validated);

        if (session()->has('cliente') && session('cliente')->cliente_id == $cliente->cliente_id) {
            session(['cliente' => $cliente]);
        }

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
                'cliente' => $cliente
            ]);
            
            return redirect()->route('site.sobre');
        }
    
            public function logoutCliente()
        {
            session()->flush();
    
            return redirect()->route('cliente.login');
        }
    
}


