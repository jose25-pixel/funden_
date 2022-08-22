<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        DB::table('proveedores')->insert([
            'nombre' => 'San Benitos',
            'tipo_documento' => 'DNI',
            'num_documento' => 3344,
            'direccion' => 'San Salvador',
            'telefono' => 22234567,
            'email' => 'benitos@gmail.com',
            'contacto' => 'Zabaleta',
            'telefono_contacto' => 78907654
            
        ]);


        DB::table('proveedores')->insert([
            'nombre' => 'La Vida',
            'tipo_documento' => 'DNI',
            'num_documento' => 34344,
            'direccion' => 'San Salvador',
            'telefono' => 22434567,
            'email' => 'vida@gmail.com',
            'contacto' => 'Esmeralda',
            'telefono_contacto' => 78907654
            
        ]);
        
    }
}
