<?php

namespace App\Http\Controllers\Correos;

use App\Http\Controllers\Controller;
use App\Mail\RecoveryPasswordMail;
use App\Models\UserModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CorreosController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $user = UserModel::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Correo no encontrado'], 404);
        }

        // Generar un token de restablecimiento único
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $baseUrl = 'http://localhost:5173';
        $resetLink = "{$baseUrl}/actualizar-contrasena/{$token}";

        Mail::to($user->email)->send(new RecoveryPasswordMail($resetLink));

        $data = [
            'message' => 'Correo enviado correctamente.',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
