<?php

namespace Database\Seeders;

use App\Models\ProcedimentoModel;
use App\Models\TipoModel;
use Illuminate\Database\Seeder;

/*
 * Procedimentos de cada categoria. É daqui que o carrossel tira, por categoria:
 *   - os chips ............ nome dos procedimentos
 *   - o texto do card ..... descrição do 1º procedimento
 *   - a foto .............. imagem do 1º procedimento que tiver (arquivo em public/images)
 *   - o "A partir de" ..... menor preço (preço 0,00 = sem valor definido: "Consulte no agendamento")
 *
 * Não altera a estrutura do banco. Rode depois do TipoSeeder.
 * Valores marcados com (*) são ilustrativos — ajuste em Admin > Procedimentos.
 */
class ProcedimentoSeeder extends Seeder
{
    public function run(): void
    {
        $procedimentos = [
            'Cabelo' => [
                ['Corte',         150, 'Do corte à coloração, com cuidado em cada fio.', 'mulher-cortando-o-cabelo-no-salao-de-beleza_23-2149167396.jpg'],
                ['Coloração',     250, 'Coloração completa (*).'],
                ['Botox capilar', 300, 'Alinhamento e brilho dos fios (*).'],
                ['Escova',        150, 'Escova modelada (*).'],
            ],
            'Manicure' => [
                ['Cutilagem',     45, 'Cutilagem cuidadosa e esmaltação tradicional ou em gel.', 'manicure.png'],
                ['Esmaltação',    55, 'Esmaltação tradicional (*).'],
                ['Gel',           70, 'Esmaltação em gel (*).'],
            ],
            'Pedicure' => [
                ['Cutilagem',     0, 'Pés macios, unhas alinhadas e esmaltação perfeita.'],
                ['Esfoliação',    0, 'Esfoliação dos pés.'],
                ['Esmaltação',    0, 'Esmaltação dos pés.'],
            ],
            'Massagem' => [
                ['Relaxante',     0, 'Um momento para desacelerar e relaxar o corpo.'],
                ['Modeladora',    0, 'Massagem modeladora.'],
            ],
            'Limpeza de pele' => [
                ['Higienização',  0, 'Pele renovada, hidratada e com viço de verdade.'],
                ['Extração',      0, 'Extração de cravos e impurezas.'],
                ['Hidratação',    0, 'Hidratação facial.'],
            ],
            'Maquiagem' => [
                ['Social',        0, 'Produção para o dia a dia, festas e grandes ocasiões.'],
                ['Festa',         0, 'Maquiagem para festas.'],
                ['Noivas',        0, 'Maquiagem para noivas.'],
            ],
            'Depilação' => [
                ['Cera quente',   20,  'Depilação com cera quente para pele lisa e duradoura.', 'depilacao.png'],
                ['Corpo todo',    180, 'Depilação completa (*).'],
            ],
        ];

        foreach ($procedimentos as $nomeTipo => $lista) {
            $tipo = TipoModel::where('nome', $nomeTipo)->first();
            if (!$tipo) {
                continue;
            }

            foreach ($lista as $item) {
                ProcedimentoModel::updateOrCreate(
                    ['tipo_id' => $tipo->tipo_id, 'nome' => $item[0]],
                    ['preco' => $item[1], 'descricao' => $item[2], 'imagem' => $item[3] ?? null]
                );
            }
        }
    }
}
