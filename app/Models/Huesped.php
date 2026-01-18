<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Huesped extends Model
{
    protected $table = 'huespedes';
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
