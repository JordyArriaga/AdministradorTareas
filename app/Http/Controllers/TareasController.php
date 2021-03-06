<?php

namespace App\Http\Controllers;

use App\Tareas;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'nombre' => 'required',
                'descripcion' => 'required'
                ], 
                [
                'nombre.required' => '¡Debes ingresar el nombre de la Tarea!',
                'descripcion.required' => '¡Debes ingresar la decripción de la Tarea!',
                ]
            );
            $tarea = new Tareas();
            $tarea->nombre = $request->nombre;
            $tarea->descripcion = $request->descripcion;
            $tarea->estado = 0;
            $tarea->idUser = Auth()->user()->id;
            $tarea->save();
            return redirect()->route('home')->withInput()->with('success', 'La tearea se ha registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function show(Tareas $tareas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tareas $tareas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $tarea = Tareas::find($id);
        $auxiliar = $tarea->Estado;
        $auxiliar= $auxiliar +1;
        $tarea->Estado = $auxiliar;
        //dd($tarea, $tarea->Estado, $auxiliar);
        $tarea->update();
        switch ($tarea->Estado) {
            case 1:
                return redirect()->route('home')->withInput()->with('warning', 'La tarea se ha empezado correctamente');       
                break;
            case 2:
                return redirect()->route('home')->withInput()->with('success', 'La tarea se ha completado correctamente');
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tareas::destroy($id);
        if(Tareas::find($id) == null){
            return redirect()->back()->withInput()->with('info', 'La tarea se ha eliminado correctamente');
        }
        return redirect()->back()->withInput()->with('info', 'Ocurrio un problema al eliminar la tarea');
    }
}
