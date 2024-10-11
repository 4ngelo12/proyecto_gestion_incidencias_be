<?php

namespace App\Http\Controllers\Acciones;

use App\Http\Controllers\Controller;
use App\Models\AccionesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccionesController extends Controller
{
    public function index()
    {
        $acciones = AccionesModel::all();

        if ($acciones->isEmpty()) {
            $data = [
                'message' => 'No hay acciones registradas',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'acciones encontradas',
            'status' => 200,
            'data' => $acciones
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'descripcion' => 'string',
            'imagen' => 'string',
            'fecha_accion' => 'required|date_format:d/m/Y',
            'incidencia_id' => 'required|integer',
            'usuario_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $acciones = AccionesModel::create($validatedData);

        if (!$acciones) {
            return response()->json([
                'message' => 'Error al registrar la accion',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'accion registrada correctamente',
            'status' => 201,
            'data' => $acciones
        ];

        return response()->json($response, 201);
    }

    public function show(string $id)
    {
        $acciones = AccionesModel::find($id);

        if (!$acciones) {
            $data = [
                'message' => 'La accion no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'accion encontrada',
            'status' => 200,
            'data' => $acciones
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $acciones = AccionesModel::find($id);

        if (!$acciones) {
            return response()->json([
                'message' => 'acciones no encontrada',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'descripcion' => 'string',
            'imagen' => 'string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $acciones->fill($validatedData);

        if (!$acciones->save()) {
            return response()->json([
                'message' => 'Error actualizando la acciones',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Datos de la acciones actualizados correctamente',
            'status' => 200,
            'data' => $acciones
        ];

        return response()->json($response, 200);
    }
}
