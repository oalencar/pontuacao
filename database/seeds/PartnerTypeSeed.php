<?php

use Illuminate\Database\Seeder;

class PartnerTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'description' => 'Consultor Celmar', 'company_id' => 1,],

        ];

        foreach ($items as $item) {
            \App\PartnerType::create($item);
        }
    }
}
