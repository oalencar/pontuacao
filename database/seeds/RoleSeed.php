<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'title' => 'Administrador',],
            ['id' => 2, 'title' => 'Gerente',],
            ['id' => 3, 'title' => 'Profissional',]

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
