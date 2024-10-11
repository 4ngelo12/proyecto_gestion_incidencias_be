<?php

namespace Database\Seeders;

use App\Models\RolModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Admin'],
            ['nombre' => 'Usuario'],
        ];

        foreach ($roles as $role) {
            $newRole = new RolModel();
            $newRole->nombre = $role['nombre'];

            $newRole->save();
        }
    }
}
