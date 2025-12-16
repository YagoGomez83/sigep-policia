<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jerarquías Policiales (ordenadas por autoridad)
        $hierarchies = [
            ['name' => 'Comisario Inspector', 'rank_level' => 1],
            ['name' => 'Comisario', 'rank_level' => 2],
            ['name' => 'Subcomisario', 'rank_level' => 3],
            ['name' => 'Principal', 'rank_level' => 4],
            ['name' => 'Inspector', 'rank_level' => 5],
            ['name' => 'Subinspector', 'rank_level' => 6],
            ['name' => 'Oficial', 'rank_level' => 7],
            ['name' => 'Sargento', 'rank_level' => 8],
            ['name' => 'Cabo', 'rank_level' => 9],
            ['name' => 'Agente', 'rank_level' => 10],
        ];

        foreach ($hierarchies as $hierarchy) {
            DB::table('hierarchies')->insert([
                'name' => $hierarchy['name'],
                'rank_level' => $hierarchy['rank_level'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Lugares de Trabajo (ejemplos)
        $workplaces = [
            ['name' => 'Jefatura Central', 'location' => null],
            ['name' => 'Comisaría Primera', 'location' => null],
            ['name' => 'Comisaría Segunda', 'location' => null],
            ['name' => 'Comisaría de la Mujer', 'location' => null],
            ['name' => 'División Investigaciones', 'location' => null],
            ['name' => 'Unidad Especial', 'location' => null],
        ];

        foreach ($workplaces as $workplace) {
            DB::table('workplaces')->insert([
                'name' => $workplace['name'],
                'location' => $workplace['location'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Funciones Policiales (ejemplos)
        $jobFunctions = [
            'Jefe de Departamento',
            'Subjefe de Departamento',
            'Jefe de División',
            'Oficial de Servicio',
            'Instructor',
            'Administrativo',
            'Patrullero',
            'Investigador',
            'Sumariante',
            'Preventor',
        ];

        foreach ($jobFunctions as $function) {
            DB::table('job_functions')->insert([
                'name' => $function,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
