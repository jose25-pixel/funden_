<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        DB::table('articulos')->insert([
            'idcategoria' => 2,
            'idgramaje' => 1,
            'nombre' => 'Acetaminofen',
            'concentracion' => 500,
            'administracion' => 'Via_Oral',
            'presentacion' => 'Blister',
            'items' => '1x10'
        ]);

        DB::table('articulos')->insert([
            'idcategoria' => 2,
            'idgramaje' => 2,
            'nombre' => 'Ibutrina',
            'concentracion' => 100,
            'administracion' => 'Via_Oral',
            'presentacion' => 'Blister',
            'items' => '1x10'
        ]);


        DB::table('articulos')->insert([
            'idcategoria' => 3,
            'idgramaje' => 1,
            'nombre' => 'Analgesico',
            'concentracion' => 200,
            'administracion' => 'Via_Oral',
            'presentacion' => 'Blister',
            'items' => '1x10'
        ]);
    }
}
