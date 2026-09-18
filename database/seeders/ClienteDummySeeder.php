<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClienteModel;

class ClienteDummySeeder extends Seeder
{
    
    public function run(): void
    {

        ClienteModel::create(['nome' => 'Administrador',
            'sobrenome' => 'Sistema',
            'cpf' => '00000000000',
            'telefone' => '11999999999',
            'email' => 'admin@admin.com',
            'data_nascimento' => '1990-01-01',
            'is_admin' => true,
            'senha' => 'Admin@1234!']);

        ClienteModel::create(['nome' => 'Usuario',
            'sobrenome' => 'Sistema',
            'cpf' => '00000000001',
            'telefone' => '11999999991',
            'email' => 'usuario@usuario.com',
            'data_nascimento' => '1990-09-16',
            'is_admin' => false,
            'senha' => 'Usuario@1234!']);

    }
}
