<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            SeveridadSeeder::class,
            EstadoIncidenciaSeeder::class
        ]);
    }
}
