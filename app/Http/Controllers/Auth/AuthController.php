<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $user = UserModel::create($validatedData);

        if (!$user) {
            return response()->json([
                'message' => 'Error creando usuario',
                'status' => 500
            ], 500);
        }

        $response = [
            'status' => 201,
            'data' => $user
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        try {
            // Intentar autenticar y generar el token JWT
            if (!$token = JWTAuth::attempt($validatedData)) {
                return response()->json([
                    'message' => 'Credenciales Inválidas',
                    'status' => 401
                ], 401);
            }

            // Obtener el usuario autenticado
            $user = JWTAuth::user();

            // Verificar si el usuario está desactivado
            if (!$user->state) {
                return response()->json([
                    'message' => 'El usuario está desactivado',
                    'status' => 403
                ], 403);
            }


            // Definir reclamaciones personalizadas (incluyendo 'role_id')
            $customClaims = [
                'role' => $user->role->name,
            ];

            // Generar el token JWT con reclamaciones personalizadas
            $token = JWTAuth::claims($customClaims)->attempt($validatedData);

            return response()->json([
                'token' => $token
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'No se pudo crear el token de acceso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
