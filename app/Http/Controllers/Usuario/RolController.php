<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\RolModel;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $role = RolModel::all();

        if ($role->isEmpty()) {
            $data = [
                'message' => 'No hay roles registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Roles encontrados',
            'status' => 200,
            'data' => $role
        ];

        return response()->json($data, 200);
    }
    public function show(string $id)
    {
        $role = RolModel::find($id);

        if (!$role) {
            $data = [
                'message' => 'Rol no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Roles encontrados',
            'status' => 200,
            'data' => $role
        ];

        return response()->json($data, 200);
    }
}
