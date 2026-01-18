<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Exception;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo='Habitaciones';
        $habitaciones=Habitacion::all();
        return view('modules.habitaciones.index',compact('habitaciones','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo='Crear Habitaciones';
        return view('modules.habitaciones.create',compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try
        {
            $habitacion=new Habitacion();
            $habitacion->numero=$request->numero;
            $habitacion->tipo=$request->tipo;
            $habitacion->precio=$request->precio;
            $habitacion->estado=$request->estado; 
            $habitacion->save();
            
            return to_route('habitaciones')->with('success','Habitación creada correctamente');
        }
        catch(Exception $e){
            return to_route('habitaciones')->with('error','No se pudo crear la habitación !'.$e->getMessage());
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
        $titulo='Editar Habitaciones';
        $habitacion = Habitacion::findOrFail($id);
        return view('modules.habitaciones.edit',compact('habitacion','titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return to_route('habitaciones')
                ->with('error', 'Habitación no encontrada');
        }

        $habitacion->numero   = $request->numero;
        $habitacion->tipo = $request->tipo;
        $habitacion->precio   = $request->precio;
        $habitacion->estado = $request->estado;

        $habitacion->save();

        return to_route('habitaciones')
            ->with('success', 'Habitación actualizada exitosamente');

        } catch (\Throwable $th) {

            return to_route('habitaciones')
                ->with('error', 'No se pudo actualizar. ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $habitacion=Habitacion::find($id);
            if (!$habitacion->canDelete()) {
                return to_route('habitaciones')->with('error', 'No se puede eliminar la habitación porque tiene reservas asociadas.');
            }
            $habitacion->delete();
            return to_route('habitaciones')->with('success',"se ha eliminado correctamente");
        }catch(\Throwable $th){
            return to_route('habitaciones')->with('error','no se ha podido eliminar ',$th->getMessage());
        }
    }
}
