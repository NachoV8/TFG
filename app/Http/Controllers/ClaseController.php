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

        $clases = Clase::all();
        // Obtener todos los profesores (usuarios con rol = 2)
        $profesores = User::where('rol', 2)->get();

        // Obtener las clases disponibles (donde id_alumno es null) de todos los profesores
        $clasesDisponibles = Clase::whereIn('id_profesor', $profesores->pluck('id'))
            ->where('id_alumno', null)
            ->with('alumno', 'profesor')
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view("clases.index", compact("clases","clasesDisponibles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else {
            // Obtener todas las pistas disponibles (estado = 0)
            $pistasDisponibles = Pista::where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

            $profesores = User::where('rol', 2)->get();

            // Devolver la vista del formulario de creación de clase junto con las pistas disponibles
            return view('clases.create', compact('pistasDisponibles', 'profesores'));
        }

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

        return redirect()->route('clases');


    }

    /**
     * Display the specified resource.
     */
    public function show(Clase $clase)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else{
            $pistaSeleccionada = $clase->pista;
            // Obtener todas las pistas disponibles (estado = 0)
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
        //
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


        if (!empty($validatedData['id_alumno'])) {
            $alumno = User::where('email', $validatedData['id_alumno'])->first();
            if ($alumno) {
                $clase->id_alumno = $alumno->id;
            } else {
                // Si el correo electrónico del alumno no existe, mostrar un mensaje de error
                return back()->withErrors(['id_alumno' => 'El correo electrónico proporcionado no existe']);
            }
        } else {
            // Si el campo id_alumno está vacío, establecer el valor como null
            $clase->id_alumno = null;
        }

        // Actualizar otros campos de la clase
        $clase->id_profesor = $validatedData['id_profesor'];
        $clase->id_pista = $validatedData['id_pista'];
        $clase->descripcion = $validatedData['descripcion'];
        $clase->precio = $validatedData['precio'];

        // Guardar los cambios
        $clase->save();

        return redirect()->route('clases');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $clase)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else{
            $pista = $clase->pista;

            // Eliminar la clase
            $clase->delete();

            // Actualizar el estado de la pista y el id_usuario
            $pista->estado = '0'; // Liberar la pista
            $pista->id_usuario = null; // Eliminar el id del usuario asociado
            $pista->save();

            return redirect()->route('clases');
        }
    }

    public function reservarClase($id_clase)
    {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {
            // Obtener el usuario autenticado
            $id_usuario = Auth::id();

            Clase::where('id_clase', $id_clase)->update(['id_alumno' => $id_usuario]);
            // Asignar el id_alumno al id del usuario autenticado

            return redirect()->back()->with('info','Mensaje enviado');
        } else {
            // Redirigir al login si el usuario no está autenticado
            return redirect()->route('login');
        }
    }

    public function cancelarClase($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->id_alumno = null;
        $clase->save();

        // Devolver la vista con los datos obtenidos
        return redirect()->route('perfil');
    }


    public function eliminarClasesAnteriores()
    {
        // Obtener la fecha actual del sistema
        $fechaActual = Carbon::now()->format('Y-m-d');
        $horaActual = Carbon::now()->format('H:i');

        // Inicializar un array para almacenar los IDs de las pistas asociadas a las clases que serán eliminadas
        $pistasAEliminar = [];

        // Obtener las clases con fecha anterior a la fecha actual y hora_inicio anterior a la hora actual
        // Incluyendo tanto las clases con id_alumno no nulo como las clases sin alumno
        $clases = Clase::where(function ($query) use ($fechaActual, $horaActual) {
            $query->where('fecha', '<', $fechaActual)
                ->orWhere(function ($query) use ($fechaActual, $horaActual) {
                    $query->where('fecha', $fechaActual)
                        ->where('hora_inicio', '<', $horaActual);
                });
        })
            ->get();

        // Procesar cada clase encontrada
        foreach ($clases as $clase) {
            // Si la clase tiene un alumno reservado
            if (!is_null($clase->id_alumno)) {
                // Pasar el id_alumno de la clase a null
                $clase->id_alumno = null;
                $clase->save();
            }

            // Guardar el ID de la pista asociada a la clase
            $pistasAEliminar[] = $clase->id_pista;

            // Eliminar la clase
            $clase->delete();
        }

        // Eliminar las pistas asociadas a las clases eliminadas
        Pista::whereIn('id_pista', $pistasAEliminar)->delete();
    }
}
