<?php

namespace App\Http\Controllers;

class ClienteController extends Controller
{
    public function dashboard()
    {
        return view('cliente.dashboard');
    }

    public function perfil()
    {
        return view('cliente.perfil');
    }

    public function agendamentos()
    {
        return view('cliente.agendamentos');
    }
}