<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriaSeeder::class);
        $this->call(GramajesSeeder::class);
        $this->call(MedicamentosSeeder::class);
        $this->call(InventariosSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(ClienteSeeder::class);



    }
}
