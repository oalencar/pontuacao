<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$747xyRMa4jfCywN3lAA4WeZgm8oCKrzKRYIxN9jfd9XvnOjMY1Ole', 'role_id' => 1, 'remember_token' => '',],
            ['id' => 2, 'name' => 'Fulano Consultor Sierra', 'email' => 'consultor@sierrabelem.com.br', 'password' => '$2y$10$fUUfikYN68Y7fcFYCHtLTOigIhCoPAPwATKbGtvaMfphtditCYyOi', 'role_id' => 3, 'remember_token' => null,],

        ];

        foreach ($items as $item) {
            \App\Models\User::create($item);
        }
    }
}
