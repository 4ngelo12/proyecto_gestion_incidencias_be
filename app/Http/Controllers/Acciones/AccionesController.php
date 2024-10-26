<?php

namespace App\Http\Controllers\Acciones;

use App\Http\Controllers\Controller;
use App\Models\AccionesModel;
use App\Models\IncidenciaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        foreach ($acciones as $accion) {
            $accion->imagen_url = url('images/acciones/' . $accion->imagen);
        }

        $data = [
            'message' => 'acciones encontradas',
            'status' => 200,
            'data' => $acciones
        ];

        return response()->json($data, 200);
    }

    public function topUsuariosConMasAcciones()
    {
        // Obtener los 10 primeros usuarios con más acciones registradas
        $usuarios = AccionesModel::select('usuario_id', DB::raw('count(*) as total_acciones'))
            ->groupBy('usuario_id')
            ->orderByDesc('total_acciones')
            ->take(10)
            ->with('usuario')  // Incluimos los datos de usuario
            ->get();

        // Verificamos si hay usuarios
        if ($usuarios->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron usuarios con acciones registradas',
                'status' => 200
            ], 200);
        }

        // Mapeamos los resultados y agregamos los datos del usuario
        $usuariosConDetalles = $usuarios->map(function ($usuario) {
            return [
                'usuario_id' => $usuario->usuario_id,
                'total_acciones' => $usuario->total_acciones,
                'nombre_usuario' => $usuario->usuario->nombre_usuario, // Nombre del usuario
                'email' => $usuario->usuario->email // Ejemplo adicional
            ];
        });

        return response()->json([
            'message' => 'Usuarios con más acciones encontradas',
            'status' => 200,
            'data' => $usuariosConDetalles
        ], 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'descripcion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fecha_accion' => 'required|date_format:Y-m-d',
            'incidencia_id' => 'required|integer',
            'usuario_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        $validatedData = $validation->validated();

        // Obtener la incidencia para verificar su fecha de registro
        $incidencia = IncidenciaModel::find($validatedData['incidencia_id']);
        if (!$incidencia) {
            return response()->json([
                'message' => 'Incidencia no encontrada',
                'status' => 404
            ], 404);
        }

        // Validar que la fecha_accion sea mayor a la fecha_reporte de la incidencia
        if ($validatedData['fecha_accion'] <= $incidencia->fecha_reporte) {
            return response()->json([
                'message' => 'La fecha de cierre debe ser mayor a la fecha de registro de la incidencia',
                'status' => 400
            ], 400);
        }

        // Procesar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('images/acciones'), $nombreImagen);
            $validatedData['imagen'] = $nombreImagen;
        }

        $acciones = AccionesModel::create($validatedData);

        if (!$acciones) {
            return response()->json([
                'message' => 'Error al registrar la accion',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Acción registrada correctamente',
            'status' => 201,
            'data' => $acciones
        ], 201);
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
