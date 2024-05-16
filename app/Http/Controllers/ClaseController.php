<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Http\Requests\StoreClaseRequest;
use App\Http\Requests\UpdateClaseRequest;
use App\Models\Pista;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clases = Clase::with('alumno')->with('profesor')->get();

        $clasesP1 = Clase::where('id_profesor', 8)->where('id_alumno', null)->get();
        $clasesP2 = Clase::where('id_profesor', 2)->where('id_alumno', null)->get();

        return view("clases.index", compact("clases", "clasesP1", "clasesP2"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las pistas disponibles (estado = 0)
        $pistasDisponibles = Pista::where('estado', 0)->get();

        $profesores = User::where('rol', 2)->get();

        // Devolver la vista del formulario de creación de clase junto con las pistas disponibles
        return view('clases.create', compact('pistasDisponibles', 'profesores'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClaseRequest $request)
    {
        $pista = Pista::find($request->pista);

        // Actualizar el estado de la pista seleccionada
        $pista->estado = 1; // Ocupado
        $pista->id_usuario = $request->id_profesor; // Asignar el id del profesor

        // Guardar los cambios en la pista
        $pista->save();

        // Crear una nueva clase con los datos del formulario
        $clase = new Clase();
        $clase->id_profesor = $request->id_profesor;
        $clase->precio = $request->precio;
        $clase->descripcion = $request->descripcion;
        $clase->id_pista = $request->pista;
        $clase->fecha = $pista->fecha; // Asignar la fecha de la pista a la clase
        $clase->hora_inicio = $pista->hora_inicio; // Asignar la hora de inicio de la pista a la clase
        $clase->save();

        $clases = Clase::all();

        $clasesP1 = Clase::where('id_profesor', 8)->get();
        $clasesP2 = Clase::where('id_profesor', 2)->get();

        return view("clases.index", compact("clases", "clasesP1", "clasesP2"));

    }

    /**
     * Display the specified resource.
     */
    public function show(Clase $clase)
    {

        // Obtener todas las pistas disponibles (estado = 0)
        $pistasDisponibles = Pista::where('estado', 0)->orderBy('pista')->orderBy('fecha')->orderBy('hora_inicio')->get();


        $profesores = User::where('rol', 2)->get();

        // Devolver la vista del formulario de creación de clase junto con las pistas disponibles
        return view('clases.edit', compact('clase', 'profesores', 'pistasDisponibles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clase $clase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClaseRequest $request, Clase $clase)
    {
        $clase->update($request->input());//se ejecuta el update

        $clases = Clase::all();

        $clasesP1 = Clase::where('id_profesor', 8)->where('id_alumno', null)->get();
        $clasesP2 = Clase::where('id_profesor', 2)->where('id_alumno', null)->get();

        return view("clases.index", compact("clases", "clasesP1", "clasesP2"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $clase)
    {
        $pista = $clase->pista;

        // Eliminar la clase
        $clase->delete();

        // Actualizar el estado de la pista y el id_usuario
        $pista->estado = '0'; // Liberar la pista
        $pista->id_usuario = null; // Eliminar el id del usuario asociado
        $pista->save();

        // Obtener todas las clases nuevamente
        $clases = Clase::all();

        // Obtener las clases para los diferentes profesores
        $clasesP1 = Clase::where('id_profesor', 1)->where('id_alumno', null)->get();
        $clasesP2 = Clase::where('id_profesor', 2)->where('id_alumno', null)->get();

        // Redirigir o mostrar la vista
        return view("clases.index", compact("clases", "clasesP1", "clasesP2"));

    }

    public function reservarClase($id_clase)
    {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {
            // Obtener el usuario autenticado
            $id_usuario = Auth::id();

            Clase::where('id_clase', $id_clase)->update(['id_alumno' => $id_usuario]);
            // Asignar el id_alumno al id del usuario autenticado

            $clases = Clase::all();

            // Obtener las clases para los diferentes profesores
            $clasesP1 = Clase::where('id_profesor', 8)->where('id_alumno', null)->get();
            $clasesP2 = Clase::where('id_profesor', 2)->where('id_alumno', null)->get();

            // Redirigir o mostrar la vista
            return view("clases.index", compact("clases", "clasesP1", "clasesP2"));
        } else {
            // Redirigir al login si el usuario no está autenticado
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar una clase.');
        }
    }

    public function cancelarClase($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->id_alumno = null;
        $clase->save();

        $userId = Auth::id();

        // Obtener las reservas del usuario logueado
        // Obtener las sesiones de pistas reservadas por el usuario
        $reservasPistas = Pista::where('id_usuario', $userId)->get();

        // Obtener las clases reservadas por el usuario
        $reservasClases = Clase::where('id_alumno', $userId)->get();

        // Devolver la vista con los datos obtenidos
        return view('perfil', compact('reservasPistas', 'reservasClases'));
    }
}
