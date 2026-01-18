<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{   
    protected $table = 'habitaciones';
    protected $fillable = [
        'numero',
        'tipo',
        'precio',
        'estado'
    ];
    public function reservas(){
        return $this->hasMany(Reserva::class, 'habitaciones_id');
    }
}
