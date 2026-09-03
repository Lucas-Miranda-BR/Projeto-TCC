<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcedimentoModel;

class ProcedimentoSeeder extends Seeder
{
    public function run(): void
    {
        ProcedimentoModel::create(['tipo_id' => 1, 'nome' => 'Manicure Clássica', 'descricao' => 'Corte, lixamento, cuticulagem e esmaltação simples.', 'preco' => 35.00]);
        ProcedimentoModel::create(['tipo_id' => 1, 'nome' => 'Alongamento em Gel', 'descricao' => 'Alongamento de unhas com gel e finalização.', 'preco' => 120.00]);

        ProcedimentoModel::create(['tipo_id' => 2, 'nome' => 'Pedicure Completa', 'descricao' => 'Spa dos pés, cuticulagem e esmaltação.', 'preco' => 45.00]);
        ProcedimentoModel::create(['tipo_id' => 2, 'nome' => 'Plástica dos Pés', 'descricao' => 'Remoção de calosidades e hidratação profunda.', 'preco' => 70.00]);

        ProcedimentoModel::create(['tipo_id' => 3, 'nome' => 'Corte Feminino', 'descricao' => 'Corte feminino com lavagem e secagem.', 'preco' => 80.00]);
        ProcedimentoModel::create(['tipo_id' => 3, 'nome' => 'Corte Masculino', 'descricao' => 'Corte masculino clássico ou degradê.', 'preco' => 45.00]);

        ProcedimentoModel::create(['tipo_id' => 4, 'nome' => 'Mechas / Luzes', 'descricao' => 'Procedimento de mechas no papelote com tonalização.', 'preco' => 250.00]);
        ProcedimentoModel::create(['tipo_id' => 4, 'nome' => 'Retoque de Raiz', 'descricao' => 'Aplicação de coloração apenas na raiz (até 3cm).', 'preco' => 90.00]);

        ProcedimentoModel::create(['tipo_id' => 5, 'nome' => 'Maquiagem Social', 'descricao' => 'Maquiagem completa e elaborada para festas e eventos.', 'preco' => 150.00]);
        ProcedimentoModel::create(['tipo_id' => 5, 'nome' => 'Maquiagem Express', 'descricao' => 'Maquiagem básica e rápida para o dia a dia.', 'preco' => 80.00]);
    }
}