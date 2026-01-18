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
        $rules = [
            'numero' => 'required|unique:habitaciones,numero',
            'tipo' => 'required|in:Simple,Doble,Suite',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:Disponible,Ocupada',
        ];

        $messages = [
            'numero.unique' => 'Ya existe una habitación con ese número.',
            'tipo.required' => 'El tipo de habitación es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ];

        $request->validate($rules, $messages);

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
        catch(\Throwable $th){
            return to_route('habitaciones')->with('error', 'Ocurrió un error al crear la habitación. Por favor, contacta al administrador.');
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
        $rules = [
            'numero' => 'required|unique:habitaciones,numero,' . $id,
            'tipo' => 'required|in:Simple,Doble,Suite',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:Disponible,Ocupada',
        ];

        $messages = [
            'numero.unique' => 'Ya existe una habitación con ese número.',
            'tipo.required' => 'El tipo de habitación es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ];

        $request->validate($rules, $messages);

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
                ->with('error', 'Ocurrió un error al actualizar la habitación. Por favor, contacta al administrador.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $habitacion=Habitacion::find($id);
            if ($habitacion->reservas()->count() > 0) {
                $count = $habitacion->reservas()->count();
                return to_route('habitaciones')->with('error', 'No se puede eliminar la habitación porque tiene' . $count . ' reservas asociadas.');
            }
            $habitacion->delete();
            return to_route('habitaciones')->with('success',"se ha eliminado correctamente");
        }catch(\Throwable $th){
            return to_route('habitaciones')->with('error', 'Ocurrió un error al intentar eliminar la habitación. Por favor, contacta al administrador.');
        }
    }
}
