<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre_usuario',
        'email',
        'estado',
        'password',
        'rol_id'
    ];

    protected $hidden = [
        'password',
        'rol',
        'email_verified_at',
        "created_at",
        "updated_at"
    ];

    protected $appends = ['rol_name'];

    public function rol()
    {
        return $this->belongsTo(RolModel::class, 'rol_id');
    }

    public function getRolNameAttribute()
    {
        return $this->rol ? $this->rol->nombre : null;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retorna la clave primaria del usuario
    }

    public function getJWTCustomClaims()
    {
        return []; // Retorna un arreglo de reclamos personalizados
    }
}
