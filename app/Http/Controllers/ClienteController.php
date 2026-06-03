<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\ClienteModel;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    function createCliente(){
        return view('cliente.create');
    }

    function storeCliente(Request $dados){
        $validated = $dados->validate([
            'tel' => [
            'required_without:email',
            'string',
            'unique:client',
            'max:11',
            'nullable'
        ],
            'email' => [
                'required_without:tel',
                'email',
                'max:255',
                'nullable'
        ]
        ]);

        ClienteModel::create($validated);

        return redirect()->route('cliente.index')->with('success', 'Cadastro realizado.');
    }

    function indexCliente(){
        return view('cliente.read', ['clientes'=>ClienteModel::all()]);
    }

    function editCliente(string $id){
        $cliente = ClienteModel::findOrFail($id);

        return view('cliente.update', compact('cliente'));
    }

    function updateCliente(Request $dados, $id) {
        $cliente = ClienteModel::findOrFail($id);

        $validated = $dados->validate([
            'tel' => [
            'required_without:email',
            'string',
            'unique:cliente',
            'max:11',
            'nullable',
            Rule::unique('cliente', 'tel')->ignore($cliente->id)
        ],
            'email' => [
                'required_without:tel',
                'email',
                'max:255', 
                'nullable'
        ]
        ]);

        $cliente->update($validated);

        return redirect()->route('cliente.index')->with('success', 'Cadastro atualizado.');
    }

    function destroyCliente(string $id) {
            ClienteModel::destroy($id);
            return redirect()->route('cliente.index')->with('success', 'Cadastro deletado.');
        }
    
}