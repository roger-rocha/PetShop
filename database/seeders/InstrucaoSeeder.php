<?php

namespace Database\Seeders;

use App\Models\instrucao;
use Illuminate\Database\Seeder;

class InstrucaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        instrucao::create([
            'alias' => 'Senha',
            'texto' => 'Mínimo de 8 caracteres / Deve obrigatoriamente ter uma letra maiúscula (A-Z) / Deve obrigatoriamente ter um número (0-9) / Não pode ser letras sequenciais como AAA.. BBB... ou ABCDEF...  /  Não pode ser números sequencias como 12345678... nem 111 ou 222...  /  Deve ter ao menos um símbolo que não seja aspas simples ou aspas duplas.',
        ]);

        instrucao::create([
            'alias' => 'Titulo',
            'texto' => 'Digite seu titulo',
        ]);

        instrucao::create([
            'alias' => 'Descrição',
            'texto' => 'Digite sua descrição',
        ]);
    }
}
