<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\CategoriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = CategoriaModel::all();

        if ($categorias->isEmpty()) {
            $data = [
                'message' => 'No categorias found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $response = [
            'message' => 'Categorias no encontradas',
            'status' => 200,
            'data' => $categorias
        ];

        return response()->json($response, 200);
    }

    public function show(string $id)
    {
        $category = CategoriaModel::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'La categoría que buscas no existe',
                'status' => 404
            ], 404);
        }

        $response = [
            'message' => 'Category Encontrada',
            'status' => 200,
            'data' => $category
        ];

        return response()->json($response, 200);
    }
}
