<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaModel extends Model
{
    use HasFactory;

    protected $table = 'incidencia';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'fecha_reporte',
        'fecha_cierre',
        'estado',
        'estado_incidente_id',
        'severidad_id',
        'categoria_id',
        'usuario_reporte_id',
        'usuario_asignado_id'
    ];

    protected $appends = [
        'estado_incidente_name',
        'severidad_name',
        'categoria_name',
        'usuario_reporte_name',
        'usuario_asignado_name'
    ];

    protected $hidden = [
        'estado_incidente',
        'severidad',
        'severidad',
        'categoria',
        'created_at',
        'updated_at'
    ];

    public function estadoIncidente() {
        return $this->belongsTo(EstadoIncidenteModel::class, 'estado_incidente_id');
    }

    public function getEstadoIncidenteNameAttribute()
    {
        return $this->estadoIncidente ? $this->estadoIncidente->nombre : null;
    }

    public function severidad() {
        return $this->belongsTo(EstadoIncidenteModel::class, 'estado_incidente_id');
    }

    public function getSeveridadNameAttribute()
    {
        return $this->severidad ? $this->severidad->nombre : null;
    }

    public function categoria() {
        return $this->belongsTo(EstadoIncidenteModel::class, 'estado_incidente_id');
    }

    public function getCategoriaNameAttribute()
    {
        return $this->categoria() ? $this->cateogria->nombre : null;
    }

    public function usuarioReporte()
    {
        return $this->belongsTo(User::class, 'usuario_reporte_id');
    }

    public function getUsuarioReporteNameAttribute()
    {
        return $this->usuarioReporte ? $this->usuarioReporte->nombre : null;
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function getUsuarioAsignadoNameAttribute()
    {
        return $this->usuarioAsignado ? $this->usuarioAsignado->nombre : null;
    }
}
