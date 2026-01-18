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

    public static function validateReservation($habitacionId, $huespedId, $fechaEntrada, $fechaSalida) {
        // Verificar si el huésped ya tiene una reserva para esta habitación
        if (self::where('habitaciones_id', $habitacionId)
            ->where('huespedes_id', $huespedId)
            ->exists()) {
            return false;
        }

        // Verificar solapamiento de fechas para la habitación
        $overlapping = self::where('habitaciones_id', $habitacionId)
            ->where('estado', '!=', 'Cancelada')
            ->where(function ($query) use ($fechaEntrada, $fechaSalida) {
                $query->whereBetween('fecha_entrada', [$fechaEntrada, $fechaSalida])
                      ->orWhereBetween('fecha_salida', [$fechaEntrada, $fechaSalida])
                      ->orWhere(function ($q) use ($fechaEntrada, $fechaSalida) {
                          $q->where('fecha_entrada', '<=', $fechaEntrada)
                            ->where('fecha_salida', '>=', $fechaSalida);
                      });
            })
            ->exists();

        return !$overlapping;
    }
}
