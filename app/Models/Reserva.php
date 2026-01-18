<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = [
        'habitaciones_id',
        'huespedes_id',
        'fecha_entrada',
        'fecha_salida',
        'estado'
    ];

    public function habitaciones()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function huespedes()
    {
        return $this->belongsTo(Huesped::class);
    }
}
