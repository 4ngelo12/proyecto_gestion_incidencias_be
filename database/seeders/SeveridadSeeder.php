<?php

namespace Database\Seeders;

use App\Models\SeveridadModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeveridadSeeder extends Seeder
{
    public function run(): void
    {
        $severidad = [
            ['nombre' => 'Critico'],
            ['nombre' => 'Alto'],
            ['nombre' => 'Medio'],
            ['nombre' => 'Bajo'],
            ['nombre' => 'Informacion'],
        ];

        foreach ($severidad as $seve) {
            $newSeveridad = new SeveridadModel();
            $newSeveridad->nombre = $seve['nombre'];

            $newSeveridad->save();
        }
    }
}
