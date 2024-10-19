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
        'usuario_reporte_id'
    ];

    protected $appends = [
        'estado_incidente_name',
        'severidad_name',
        'categoria_name',
        'usuario_reporte_name'
    ];

    // Elimina aquellos campos innecesarios de 'hidden', y deja lo relevante
    protected $hidden = [
        'estadoIncidente',
        'severidad',
        'usuarioReporte',
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
        return $this->belongsTo(SeveridadModel::class, 'severidad_id');
    }

    public function getSeveridadNameAttribute()
    {
        return $this->severidad ? $this->severidad->nombre : null;
    }

    public function categoria() {
        return $this->belongsTo(CategoriaModel::class, 'categoria_id');
    }

    public function getCategoriaNameAttribute()
    {
        return $this->categoria ? $this->categoria->nombre : null;
    }

    public function usuarioReporte()
    {
        return $this->belongsTo(UserModel::class, 'usuario_reporte_id');
    }


    public function getUsuarioReporteNameAttribute()
    {
        return $this->usuarioReporte ? $this->usuarioReporte->nombre_usuario : null;
    }
}
