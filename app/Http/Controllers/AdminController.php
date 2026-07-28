<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function clientes()
    {
        return view('admin.clientes');

    }
    function indexCliente(){
        return view('cliente.read', ['clientes'=>ClienteModel::all()]);
    }

    public function agendamentos()
    {
        return view('admin.agendamentos');
    }

    public function calendario()
    {
        return view('admin.calendario');
    }

    public function produtos()
    {
        return view('admin.produtos');
    }
}