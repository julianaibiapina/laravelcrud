<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_users')->insert([
            'description' => 'Lojista'
        ]);

        DB::table('types_users')->insert([
            'description' => 'Usuário'
        ]);
    }
}
