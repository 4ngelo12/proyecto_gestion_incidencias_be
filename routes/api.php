<?php

use App\Http\Controllers\Acciones\AccionesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Incidencia\CategoriaController;
use App\Http\Controllers\Incidencia\EstadoIncidenteController;
use App\Http\Controllers\Incidencia\IncidenciaController;
use App\Http\Controllers\Incidencia\SeveridadController;
use App\Http\Controllers\Pdf\ReporteController;
use App\Http\Controllers\Usuario\RolController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;

//Auth
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

// Users
Route::middleware('jwt.verify')->group(function () {
    Route::get('/users/list/{id}', [UsuarioController::class, 'index']);
    Route::get('/users/activo', [UsuarioController::class, 'usuariosActivos']);
    Route::get('/users/{id}', [UsuarioController::class, 'show']);
    Route::patch('/users/{id}', [UsuarioController::class, 'updatePartial']);
    Route::delete('/users/{id}', [UsuarioController::class, 'destroy']);
});

// Roles
Route::middleware('jwt.verify')->group(function () {
    Route::get('/roles', [RolController::class, 'index']);
    Route::get('/roles/{id}', [RolController::class, 'show']);
});

/* ============================== Incidencias ============================== */

// Estado Incidente
Route::middleware('jwt.verify')->group(function () {
    Route::get('/estado_indicente', [EstadoIncidenteController::class, 'index']);
    Route::get('/estado_indicente/{id}', [EstadoIncidenteController::class, 'show']);
});

// Severidad
Route::middleware('jwt.verify')->group(function () {
    Route::get('/severidad', [SeveridadController::class, 'index']);
    Route::get('/severidad/{id}', [SeveridadController::class, 'show']);
});

// Categorias
Route::middleware('jwt.verify')->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
});

// Incidencias
Route::middleware('jwt.verify')->group(function () {
    Route::get('/incidencia', [IncidenciaController::class, 'index']);
    Route::get('/incidencia/activo', [IncidenciaController::class, 'incidentesAbiertos']);
    Route::get('/incidencia/{id}', [IncidenciaController::class, 'show']);
    Route::post('/incidencia', [IncidenciaController::class, 'store']);
    Route::delete('/incidencia/{id}', [IncidenciaController::class, 'destroy']);
    Route::put('/incidencia/{id}', [IncidenciaController::class, 'updatePartial']);
    Route::patch('/incidencia/cerrar/{id}', [IncidenciaController::class, 'cerrarIncidencia']);
});

/* ============================== Acciones ============================== */

// Acciones
Route::middleware('jwt.verify')->group(function () {
    Route::get('/acciones', [AccionesController::class, 'index']);
    Route::get('/acciones/usuarios', [AccionesController::class, 'topUsuariosConMasAcciones']);
    Route::get('/acciones/{id}', [AccionesController::class, 'show']);
    Route::post('/acciones', [AccionesController::class, 'store']);
    Route::patch('/acciones/{id}', [AccionesController::class, 'updatePartial']);
});


// Reportes
Route::middleware('jwt.verify')->group(function () {
    Route::get('reporte/{idUsuario}/incidencias/{id}/pdf', [ReporteController::class, 'generarPDF']);
});
