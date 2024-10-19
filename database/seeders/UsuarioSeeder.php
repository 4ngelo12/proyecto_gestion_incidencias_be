<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nombre_usuario' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('passwordAdmin'),
                //'estado' => true,
                'rol_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            $newUser = new UserModel();
            $newUser->nombre_usuario = $user['nombre_usuario'];
            $newUser->email = $user['email'];
            $newUser->password = $user['password'];
            //$newUser->estado = $user['estado'];
            $newUser->rol_id = $user['rol_id'];

            $newUser->save();
        }
    }
}
