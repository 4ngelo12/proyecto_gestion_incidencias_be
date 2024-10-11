<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\EstadoIncidenteModel;
use Illuminate\Http\Request;

class EstadoIncidenteController extends Controller
{
    public function index()
    {
        $categorias = EstadoIncidenteModel::all();

        if ($categorias->isEmpty()) {
            $data = [
                'message' => 'No se econtraron valores',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $response = [
            'message' => 'valores no encontrados',
            'status' => 200,
            'data' => $categorias
        ];

        return response()->json($response, 200);
    }

    public function show(string $id)
    {
        $category = EstadoIncidenteModel::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'El Estado de Incidente que buscas no existe',
                'status' => 404
            ], 404);
        }

        $response = [
            'message' => 'Estado de Incidente Encontrado',
            'status' => 200,
            'data' => $category
        ];

        return response()->json($response, 200);
    }
}
