<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'telefono',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    public function reportes(): HasMany
    {
        return $this->hasMany(Reporte::class, 'usuario_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }
}
