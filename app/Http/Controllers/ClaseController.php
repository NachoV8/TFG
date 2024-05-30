<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Http\Requests\StoreClaseRequest;
use App\Http\Requests\UpdateClaseRequest;
use App\Models\Pista;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->eliminarClasesAnteriores();

        $clases = Clase::orderBy('fecha')->orderBy('hora_inicio')->get();

        $clasesProfesor = Clase::where('id_profesor', Auth::id())
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get();


        $profesores = User::where('rol', 2)->get();

        $clasesDisponibles = Clase::whereIn('id_profesor', $profesores->pluck('id'))
            ->where('id_alumno', null)
            ->with('alumno', 'profesor')
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view("clases.index", compact("clases","clasesDisponibles", "clasesProfesor"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3 || Auth::user()->rol == 2)) {
            return redirect()->route('inicio');

        } else {

            $pistasDisponibles = Pista::where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

            $profesores = User::where('rol', 2)->get();

            return view('clases.create', compact('pistasDisponibles', 'profesores'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClaseRequest $request)
    {
        $pista = Pista::find($request->pista);

        $pista->estado = 1; // Ocupado
        $pista->id_usuario = $request->id_profesor;

        $pista->save();

        // Crear una nueva clase con los datos del formulario
        $clase = new Clase();
        $clase->id_profesor = $request->id_profesor;
        $clase->precio = $request->precio;
        $clase->descripcion = $request->descripcion;
        $clase->id_pista = $request->pista;
        $clase->fecha = $pista->fecha;
        $clase->hora_inicio = $pista->hora_inicio;

        $clase->save();

        return redirect()->route('clases');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clase $clase)
    {
        if (!(Auth::check() && Auth::user()->rol == 3 || Auth::user()->rol == 2)) {
            return redirect()->route('inicio');
        } else {
            $pistaSeleccionada = $clase->pista;

            $pistasDisponibles = Pista::where('estado', 0)->orderBy('pista')->orderBy('fecha')->orderBy('hora_inicio')->get();

            // Agregar la pista seleccionada a la lista de pistas disponibles
            $pistasDisponibles->push($pistaSeleccionada);

            $profesores = User::where('rol', 2)->get();

            return view('clases.edit', compact('clase', 'profesores', 'pistasDisponibles'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clase $clase)
    {
        //Se realiza todo en show y se actualiza en update
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClaseRequest $request, Clase $clase)
    {
        $validatedData = $request->validate([
            'id_profesor' => 'required|exists:users,id',
            'id_alumno' => 'nullable|exists:users,email',
            'id_pista' => 'required|exists:pistas,id_pista',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        // Guardar el id_pista anterior
        $idPistaAnterior = $clase->id_pista;

        // Actualizar la hora de inicio y la fecha si la pista ha cambiado
        if ($idPistaAnterior != $validatedData['id_pista']) {
            // Desocupar la pista anterior
            $pistaAnterior = Pista::find($clase->id_pista);
            $pistaAnterior->estado = 0;
            $pistaAnterior->id_usuario = null;
            $pistaAnterior->save();

            // Ocupar la nueva pista con el profesor actual
            $pistaNueva = Pista::find($validatedData['id_pista']);
            $pistaNueva->estado = 1;
            $pistaNueva->id_usuario = $validatedData['id_profesor'];
            $pistaNueva->save();

            // Actualizar la hora de inicio y la fecha de la clase con la nueva pista
            $clase->hora_inicio = $pistaNueva->hora_inicio;
            $clase->fecha = $pistaNueva->fecha;
        }

        // Comprobar si el alumno existe o no o no hay
        if (!empty($validatedData['id_alumno'])) {
            $alumno = User::where('email', $validatedData['id_alumno'])->first();
            if ($alumno) {
                $clase->id_alumno = $alumno->id;
            } else {
                // Si el correo electrónico del alumno no existe, mostrar un mensaje de error
                return back()->withErrors(['id_alumno' => 'El correo electrónico proporcionado no existe']);
            }
        } else {
            $clase->id_alumno = null; //No hay alumno
        }

        // Actualizar otros campos de la clase con los requisitos
        $clase->id_profesor = $validatedData['id_profesor'];
        $clase->id_pista = $validatedData['id_pista'];
        $clase->descripcion = $validatedData['descripcion'];
        $clase->precio = $validatedData['precio'];

        $clase->save();

        return redirect()->route('clases');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $clase)
    {
        if (!(Auth::check() && Auth::user()->rol == 3 || Auth::user()->rol == 2)) {
            return redirect()->route('inicio');
        } else {
            $pista = $clase->pista;

            $clase->delete();

            $pista->estado = '0'; // Libre
            $pista->id_usuario = null;

            $pista->save();

            return redirect()->route('clases');
        }
    }



    // Funcion para reservar clase
    public function reservarClase($id_clase)
    {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {

            $id_usuario = Auth::id();

            Clase::where('id_clase', $id_clase)->update(['id_alumno' => $id_usuario]);

            return redirect()->back()->with('info','Mensaje enviado');
        } else {
            // Redirigir al login si el usuario no está autenticado
            return redirect()->route('login');
        }
    }


    // Funcion para cancelar la reserva a una clase
    public function cancelarClase($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->id_alumno = null;

        $clase->save();

        return redirect()->route('perfil');
    }

    // Funcion para eliminar las clases una vez ha pasado la hora
    public function eliminarClasesAnteriores()
    {
        // Obtener la fecha actual del sistema
        $fechaActual = Carbon::now()->format('Y-m-d');
        $horaActual = Carbon::now()->format('H:i');

        $pistasAEliminar = [];

        // Obtener las clases con fecha anterior a la fecha actual y hora_inicio anterior a la hora actual
        $clases = Clase::where(function ($query) use ($fechaActual, $horaActual) {
            $query->where('fecha', '<', $fechaActual)
                ->orWhere(function ($query) use ($fechaActual, $horaActual) {
                    $query->where('fecha', $fechaActual)
                        ->where('hora_inicio', '<', $horaActual);
                });
        })->get();

        foreach ($clases as $clase) {
            if (!is_null($clase->id_alumno)) {
                $clase->id_alumno = null;
                $clase->save();
            }

            $pistasAEliminar[] = $clase->id_pista;

            $clase->delete();
        }

        //Eliminamos las pistas despues de eliminar la clase
        Pista::whereIn('id_pista', $pistasAEliminar)->delete();
    }
}
