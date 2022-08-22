<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        DB::table('inventarios')->insert([
            'idproducto' => 1
        ]);

        DB::table('inventarios')->insert([
            'idproducto' => 2
        ]);

        DB::table('inventarios')->insert([
            'idproducto' => 3
        ]);
    }
}
