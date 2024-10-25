<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index(string $id)
    {
        $user = UserModel::where('id', '!=', $id)->with('rol')->get();

        if ($user->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Usuarios encontrados',
            'status' => 200,
            'data' => $user
        ];

        return response()->json($data, 200);
    }

    public function usuariosActivos()
    {
        $user = UserModel::where('estado', '=', 1)
            ->get(['id', 'nombre_usuario']);

        if ($user->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios activos',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $response = [
            'message' => 'Usuarios activos encontrados',
            'status' => 200,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function show(string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Usuario encontrado',
            'status' => 200,
            'data' => $user
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no fue encontrado',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'string|min:3',
            'email' => 'email|unique:usuario,email,' . $id,
            'state' => 'boolean'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();
        $user->update($validatedData);

        $response = [
            'message' => 'La información del usuario ha sido actualizada correctamente',
            'status' => 200,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function destroy(string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'El usuario no fue encontrado',
                'status' => 404
            ], 404);
        }

        $user->state = false;

        // Guardar los cambios en la base de datos
        if (!$user->save()) {
            return response()->json([
                'message' => 'Error al desactivar el usuario',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Usuario desactivado',
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
