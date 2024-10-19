<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    protected $fillable = [
        'nombre',
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function incidencias()
    {
        return $this->hasMany(IncidenciaModel::class);
    }
}
