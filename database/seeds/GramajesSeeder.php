<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GramajesSeeder extends Seeder
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
        DB::table('gramajes')->insert([
               'gramaje' => 'MG'
           ]);
        DB::table('gramajes')->insert([
            'gramaje' => 'G'
           ]);
        DB::table('gramajes')->insert([
               'gramaje' => 'Ml'
           ]);
    }
}
