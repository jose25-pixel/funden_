<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('categorias')->insert([
            'nombre' => 'San Nicolas'
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Fardel'
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Economicas'
        ]);

    }
}
