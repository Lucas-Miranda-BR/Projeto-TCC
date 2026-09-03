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
            'cep' => '00000000',
            'telefone' => '11999999999',
            'email' => 'admin@admin.com',
            'endereco' => 'Rua Principal, 123 - Centro',
            'data_nascimento' => '1990-01-01',
            'admin' => true,
            'senha' => 'Admin@1234!']);

    }
}
