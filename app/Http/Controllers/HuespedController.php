<?php

namespace App\Http\Controllers;

use App\Models\Huesped;
use Illuminate\Http\Request;
use Exception;

class HuespedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo='Huespedes';
        $huespedes=Huesped::all();
        return view('modules.huespedes.index',compact('huespedes','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo='Crear Huespedes';
        return view('modules.huespedes.create',compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|unique:huespedes,cedula',
            'telefono' => 'nullable|string|max:20',
        ];

        $messages = [
            'cedula.unique' => 'Ya existe un huésped con esa cédula.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
        ];

        $request->validate($rules, $messages);

        try
        {
            $huesped=new Huesped();
            $huesped->nombre=$request->nombre;
            $huesped->apellido=$request->apellido;
            $huesped->cedula=$request->cedula;
            $huesped->telefono=$request->telefono; 
            $huesped->save();
            
            return to_route('huespedes')->with('success','Huésped creado correctamente');
        }
        catch(\Throwable $th){
            return to_route('huespedes')->with('error', 'Ocurrió un error al crear el huésped. Por favor, contacta al administrador.');
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
        $huesped = Huesped::findOrFail($id);
        return view('modules.huespedes.edit', compact('huesped'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $item = Huesped::find($id);

        if (!$item) {
            return to_route('huespedes')
                ->with('error', 'Huésped no encontrado');
        }

        $item->nombre   = $request->nombre;
        $item->apellido = $request->apellido;
        $item->cedula   = $request->cedula;
        $item->telefono = $request->telefono;

        $item->save();

        return to_route('huespedes')
            ->with('success', 'Huésped actualizado exitosamente');

        } catch (\Throwable $th) {

            return to_route('huespedes')
                ->with('error', 'No se pudo actualizar. ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $huesped=Huesped::find($id);
            if ($huesped->reservas()->count() > 0) {
                $count = $huesped->reservas()->count();
                return to_route('huespedes')->with('error', 'No se puede eliminar el huésped porque tiene ' . $count . ' reservas asociadas.');
            }
            $huesped->delete();
            return to_route('huespedes')->with('success',"se ha eliminado correctamente");
        }catch(\Throwable $th){
            return to_route('huespedes')->with('error', 'Ocurrió un error al intentar eliminar el huésped. Por favor, contacta al administrador.');
        }
    }
}
