<?php

use Illuminate\Database\Seeder;

class PremiacaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Premiação Consultor Celmar', 'description' => null, 'goal' => 10500, 'start_date' => '25/11/2018', 'finish_date' => '30/11/2018', 'image' => null, 'partner_type_id' => 1, 'company_id' => 1,],

        ];

        foreach ($items as $item) {
            \App\Premiacao::create($item);
        }
    }
}
