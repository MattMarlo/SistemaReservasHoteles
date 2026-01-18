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
            if (!Reserva::validateReservation($request->habitaciones_id, $request->huespedes_id, $request->fecha_entrada, $request->fecha_salida)) {
                return to_route('reservas')->with('error', 'No se puede crear la reserva: conflicto de fechas o reserva duplicada para el huésped en esta habitación.');
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
            return to_route('reservas')->with('error','Falló al crear la reserva'.$th->getMessage());
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
        //
    }
}
