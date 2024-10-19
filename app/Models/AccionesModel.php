<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionesModel extends Model
{
    use HasFactory;

    protected $table = 'acciones';

    protected $fillable = [
        'descripcion',
        'imagen',
        'fecha_accion',
        'fecha_cierre',
        'estado',
        'incidencia_id',
        'usuario_id'
    ];

    protected $appends = ['incidencia_name', 'usuario_name'];

    protected $hidden = [
        'incidencia',
        'usuario',
    ];

    public function incidencia() {
        return $this->belongsTo(IncidenciaModel::class, 'incidencia_id');
    }

    public function getIncidenciaNameAttribute()
    {
        return $this->incidencia ? $this->incidencia->nombre : null;
    }

    public function usuario() {
        return $this->belongsTo(UserModel::class, 'usuario_id');
    }

    public function getUsuarioNameAttribute()
    {
        return $this->usuario ? $this->usuario->nombre_usuario : null;
    }
}
