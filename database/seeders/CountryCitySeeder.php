<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar países
        DB::table('nacionalidades')->insertOrIgnore([
            ['nombrenacionalidad' => 'Paraguaya'],
            ['nombrenacionalidad' => 'Argentina'],
            ['nombrenacionalidad' => 'Brasileña'],
            ['nombrenacionalidad' => 'Uruguaya'],
        ]);

        // Insertar ciudades
        DB::table('ciudades')->insertOrIgnore([
            ['nombre' => 'Villarrica'],
            ['nombre' => 'Asunción'],
            ['nombre' => 'Encarnación'],
            ['nombre' => 'Ciudad del Este'],
            ['nombre' => 'Buenos Aires'],
            ['nombre' => 'Córdoba'],
            ['nombre' => 'Rio de Janeiro'],
            ['nombre' => 'São Paulo'],
            ['nombre' => 'Montevideo'],
        ]);
    }
}
