<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Huesped;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo="Reservas";
        $reservas = Reserva::with(['huespedes', 'habitaciones'])->get();
        return view('modules.reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo="Crear Reservas";
        $habitaciones=Habitacion::all();
        $huespedes=Huesped::all();
        return view('modules.reservas.create',compact('titulo','habitaciones','huespedes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
            $habitacionId = $request->habitaciones_id;
            $huespedId = $request->huespedes_id;
            $fechaEntrada = $request->fecha_entrada;
            $fechaSalida = $request->fecha_salida;

            // Verificar si el huésped ya tiene una reserva para esta habitación
            if (Reserva::where('habitaciones_id', $habitacionId)
                ->where('huespedes_id', $huespedId)
                ->exists()) {
                return to_route('reservas')->with('error', 'El huésped ya tiene una reserva para esta habitación.');
            }

            // Verificar solapamiento de fechas para la habitación
            $overlapping = Reserva::where('habitaciones_id', $habitacionId)
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

            if ($overlapping) {
                return to_route('reservas')->with('error', 'Conflicto de fechas: la habitación ya está reservada en esas fechas.');
            }

            $reserva = new Reserva();
            $reserva->habitaciones_id=$request->habitaciones_id;
            $reserva->huespedes_id=$request->huespedes_id;
            $reserva->fecha_entrada=$request->fecha_entrada;
            $reserva->fecha_salida=$request->fecha_salida;
            $reserva->estado=$request->estado;
            $reserva->save();
            return to_route('reservas')->with('success','reserva creada exitosamente');
        }catch(\Throwable $th){
            return to_route('reservas')->with('error','Ocurrió un error al crear la reserva. Por favor, contacta al administrador.');
        } 
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $reserva = Reserva::find($id);
            if (!$reserva) {
                return to_route('reservas')->with('error', 'Reserva no encontrada.');
            }
            $reserva->delete();
            return to_route('reservas')->with('success', 'Reserva eliminada correctamente.');
        } catch (\Throwable $th) {
            return to_route('reservas')->with('error', 'Ocurrió un error al intentar eliminar la reserva. Por favor, contacta al administrador.');
        }
    }
}
