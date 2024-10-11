<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\IncidenciaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = IncidenciaModel::where('estado_incidente_id', '!=', 3)->with('estado_incidente_id')->get();

        if ($incidencias->isEmpty()) {
            $data = [
                'message' => 'No se econtraron incidencias',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $response = [
            'message' => 'incidencias no encontradas',
            'status' => 200,
            'data' => $incidencias
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => 'required|string|min:3',
            'descripcion' => 'string',
            'imagen' => 'string',
            'fecha_reporte' => 'required|date_format:d/m/Y',
            'estado_incidente_id' => 'required|integer',
            'severidad_id' => 'required|integer',
            'categoria_id' => 'required|integer',
            'usuario_reporte_id' => 'required|integer',
            'usuario_asignado_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $incidencias = IncidenciaModel::create($validatedData);

        if (!$incidencias) {
            return response()->json([
                'message' => 'Error al registrar la incidencia',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'incidencia registrada correctamente',
            'status' => 201,
            'data' => $incidencias
        ];

        return response()->json($response, 201);
    }

    public function show(string $id)
    {
        $incidencia = IncidenciaModel::find($id);

        if (!$incidencia) {
            $data = [
                'message' => 'La incidencia no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'incidencia encontrada',
            'status' => 200,
            'data' => $incidencia
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $incidencia = IncidenciaModel::find($id);

        if (!$incidencia) {
            return response()->json([
                'message' => 'incidencia no encontrada',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'nombre' => 'string|min:3',
            'descripcion' => 'string',
            'imagen' => 'string',
            'severidad_id' => 'integer',
            'categoria_id' => 'integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $incidencia->fill($validatedData);

        if (!$incidencia->save()) {
            return response()->json([
                'message' => 'Error actualizando la incidencia',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Datos de la incidencia actualizados correctamente',
            'status' => 200,
            'data' => $incidencia
        ];

        return response()->json($response, 200);
    }

    public function destroy(string $id)
    {
        $incidencia = IncidenciaModel::find($id);

        if (!$incidencia) {
            return response()->json([
                'message' => 'La incidencia no fue encontrada',
                'status' => 404
            ], 404);
        }

        $incidencia->state = false;

        // Guardar los cambios en la base de datos
        if (!$incidencia->save()) {
            return response()->json([
                'message' => 'Error al eliminar la incidencia',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Incidencia Eliminada',
            'status' => 204
        ];

        return response()->json($response, 204);
    }

    public function cerrarIncidencia(Request $request, string $id) {
        $incidencia = IncidenciaModel::find($id);

        if (!$incidencia) {
            return response()->json([
                'message' => 'incidencia no encontrada',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'fecha_cierre' => 'required|date_format:d/m/Y',
            'estado_incidente_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $incidencia->fill($validatedData);

        if (!$incidencia->save()) {
            return response()->json([
                'message' => 'Error al cerrar la incidencia',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Incidencia cerrada correctamente',
            'status' => 200,
            'data' => $incidencia
        ];

        return response()->json($response, 200);
    }
}
