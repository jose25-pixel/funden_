<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        DB::table('personas')->insert([
            'nombre' => 'Sandra Valencia',
            'tipo_documento' => 'DNI',
            'num_documento' => 33442356,
            'direccion' => 'San Salvador',
            'telefono' => 22234567,
            'email' => 'sandra@gmail.com'
            
        ]);

        DB::table('personas')->insert([
            'nombre' => 'Veronica',
            'tipo_documento' => 'DNI',
            'num_documento' => 33442356,
            'direccion' => 'San Salvador',
            'telefono' => 22234567,
            'email' => 'veronica@gmail.com'
            
        ]);

        DB::table('personas')->insert([
            'nombre' => 'Maria',
            'tipo_documento' => 'DNI',
            'num_documento' => 33442356,
            'direccion' => 'San Salvador',
            'telefono' => 22234567,
            'email' => 'saa@gmail.com'
            
        ]);
    }
}
