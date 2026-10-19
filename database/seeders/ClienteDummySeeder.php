<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClienteModel;

class ClienteDummySeeder extends Seeder
{
    public function run(): void
    {
        ClienteModel::create([
            'nome' => 'Administrador',
            'sobrenome' => 'Sistema',
            'cpf' => '00000000000',
            'telefone' => '11999999999',
            'email' => 'admin@admin.com',
            'data_nascimento' => '1990-01-01',
            'is_admin' => true,
            'senha' => 'Admin@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Usuario',
            'sobrenome' => 'Sistema',
            'cpf' => '00000000001',
            'telefone' => '11999999991',
            'email' => 'usuario@usuario.com',
            'data_nascimento' => '1990-09-16',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Joao',
            'sobrenome' => 'Silva',
            'cpf' => '00000000002',
            'telefone' => '11988887771',
            'email' => 'joao.silva@email.com',
            'data_nascimento' => '1995-03-12',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Maria',
            'sobrenome' => 'Santos',
            'cpf' => '00000000003',
            'telefone' => '11988887772',
            'email' => 'maria.santos@email.com',
            'data_nascimento' => '1992-07-25',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Pedro',
            'sobrenome' => 'Oliveira',
            'cpf' => '00000000004',
            'telefone' => '11988887773',
            'email' => 'pedro.oliveira@email.com',
            'data_nascimento' => '1988-11-08',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Ana',
            'sobrenome' => 'Souza',
            'cpf' => '00000000005',
            'telefone' => '11988887774',
            'email' => 'ana.souza@email.com',
            'data_nascimento' => '2000-01-19',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Lucas',
            'sobrenome' => 'Pereira',
            'cpf' => '00000000006',
            'telefone' => '11988887775',
            'email' => 'lucas.pereira@email.com',
            'data_nascimento' => '1997-05-30',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Juliana',
            'sobrenome' => 'Costa',
            'cpf' => '00000000007',
            'telefone' => '11988887776',
            'email' => 'juliana.costa@email.com',
            'data_nascimento' => '1994-09-14',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Gabriel',
            'sobrenome' => 'Rodrigues',
            'cpf' => '00000000008',
            'telefone' => '11988887777',
            'email' => 'gabriel.rodrigues@email.com',
            'data_nascimento' => '1999-12-03',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Fernanda',
            'sobrenome' => 'Almeida',
            'cpf' => '00000000009',
            'telefone' => '11988887778',
            'email' => 'fernanda.almeida@email.com',
            'data_nascimento' => '1991-04-21',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Rafael',
            'sobrenome' => 'Lima',
            'cpf' => '00000000010',
            'telefone' => '11988887779',
            'email' => 'rafael.lima@email.com',
            'data_nascimento' => '1986-08-17',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);

        ClienteModel::create([
            'nome' => 'Camila',
            'sobrenome' => 'Ferreira',
            'cpf' => '00000000011',
            'telefone' => '11988887780',
            'email' => 'camila.ferreira@email.com',
            'data_nascimento' => '1998-06-09',
            'is_admin' => false,
            'senha' => 'Usuario@1234!',
        ]);
    }
}
