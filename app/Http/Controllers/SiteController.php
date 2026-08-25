<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function sobre()
    {
        return view('site.sobre');
    }

    public function servicos()
    {
        return view('site.servicos');
    }

    public function produtos()
    {
        return view('site.produtos');
    }
}
