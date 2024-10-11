<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoIncidenteModel extends Model
{
    use HasFactory;

    protected $table = 'estado_incidente';

    protected $fillable = [
        'nombre',
    ];

    public function incidencias()
    {
        return $this->hasMany(IncidenciaModel::class);
    }
}
