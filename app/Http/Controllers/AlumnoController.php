<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos = Alumno::all();
        //dd($alumnos);
        return view('alumnos.index' , compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('alumnos.create');
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
            'nombre' => 'required|string|max:20',
            'apellido' => 'required|string|max:20',
            'email' => 'required|email|unique:alumnos,email',
            'edad' => 'required|integer|max:120',
        ]);

        Alumno::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'edad' => $request->edad,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Dato agregado exitosamente');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        //Muestra la pantalla para editar
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Funciona para editar los datos
        $alumno = Alumno::findOrFail($id);
    // Validar los datos, asegurando que el email sea único, excepto para el alumno actual
    $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
        'edad' => 'required|integer',
    ]);
    // Actualizar los datos del alumno
    $alumno->update($request->all());
    // Redireccionar con mensaje de éxito
    return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumnos)
    {
        $alumno->forceDelete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctaomente');
    }
}
