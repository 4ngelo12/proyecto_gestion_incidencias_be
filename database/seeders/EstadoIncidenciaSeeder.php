<?php

namespace Database\Seeders;

use App\Models\EstadoIncidenteModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoIncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $estadoIncidente = [
            ['nombre' => 'Abierto'],
            ['nombre' => 'Cerrado'],
            ['nombre' => 'Cancelado'],
        ];

        foreach ($estadoIncidente as $estInci) {
            $newEstadoIncidente = new EstadoIncidenteModel();
            $newEstadoIncidente->nombre = $estInci['nombre'];

            $newEstadoIncidente->save();
        }
    }
}
