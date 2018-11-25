<?php

use Illuminate\Database\Seeder;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'nome' => 'Celmar', 'endereco' => null, 'telefone' => null,],
            ['id' => 2, 'nome' => 'Sierra', 'endereco' => null, 'telefone' => null,],

        ];

        foreach ($items as $item) {
            \App\Company::create($item);
        }
    }
}
