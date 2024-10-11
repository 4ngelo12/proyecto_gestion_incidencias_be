<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeveridadModel extends Model
{
    use HasFactory;

    protected $table = 'severidad';

    protected $fillable = [
        'nombre',
    ];

    public function incidencias()
    {
        return $this->hasMany(IncidenciaModel::class);
    }
}
