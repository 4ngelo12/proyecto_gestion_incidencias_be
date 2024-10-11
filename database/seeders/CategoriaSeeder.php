<?php

namespace Database\Seeders;

use App\Models\CategoriaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categoria = [
            ['nombre' => 'Hardware'],
            ['nombre' => 'Software'],
            ['nombre' => 'Redes'],
            ['nombre' => 'Seguridad'],
            ['nombre' => 'Acceso y Credenciales'],
            ['nombre' => 'Base de Datos'],
        ];

        foreach ($categoria as $cat) {
            $newCategoria = new CategoriaModel();
            $newCategoria->nombre = $cat['nombre'];

            $newCategoria->save();
        }
    }
}
