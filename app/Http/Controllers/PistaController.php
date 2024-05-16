<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Pista;
use App\Http\Requests\StorePistaRequest;
use App\Http\Requests\UpdatePistaRequest;
use App\Models\Sesion;
use App\Models\Torneo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class PistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Generar automáticamente las pistas para la pista 1 y la pista 2
        $this->generarPista1Automatico();
        $this->generarPista2Automaticas();

        // Eliminar las pistas anteriores
        $this->eliminarPistasAnteriores();

        // Obtener todas las pistas ordenadas por fecha
        // Obtener todas las pistas ordenadas por fecha, hora de inicio y número de pista
        //$pistas = Pista::orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();
        $pistas = Pista::with('usuario')->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


// Obtener las pistas de la pista 1 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

// Obtener las pistas de la pista 2 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("pistas.create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePistaRequest $request)
    {
        // Obtener los datos del formulario
        $datos = $request->input();

        // Verificar si ya existe una pista con la misma fecha, hora de inicio y hora de fin
        $pistaExistente = Pista::where('fecha', $datos['fecha'])
            ->where('hora_inicio', $datos['hora_inicio'])
            ->where('hora_fin', $datos['hora_fin'])
            ->exists();

        // Si ya existe una pista con los mismos detalles, redirigir de vuelta con un mensaje de error
        if ($pistaExistente) {


            return redirect()->back()->with('error', 'Ya existe una pista con la misma fecha, hora de inicio y hora de fin.');
        }

        // Si no existe una pista con los mismos detalles, crear y guardar la nueva pista
        $pista = new Pista($datos);
        $pista->save();

        // Obtener todas las pistas para mostrarlas en la vista
        $pistas = Pista::all();

        // Obtener las pistas de cada pista específica para mostrarlas en la vista
        $pistas = Pista::with('usuario')->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


// Obtener las pistas de la pista 1 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

// Obtener las pistas de la pista 2 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));

    }

    /**
     * Display the specified resource.
     */
    public function show(Pista $pista)
    {
        return view("pistas.edit", compact("pista"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pista $pista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePistaRequest $request, Pista $pista)
    {
        //dd($request->input());

        $pista->update($request->input());//se ejecuta el update

        // Obtener las pistas de cada pista específica para mostrarlas en la vista
        $pistas = Pista::with('usuario')->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


// Obtener las pistas de la pista 1 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

// Obtener las pistas de la pista 2 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));
        //return view("pistas.index", compact("pistas"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pista $pista)
    {
        $pista->delete();

        // Obtener las pistas de cada pista específica para mostrarlas en la vista
        $pistas = Pista::with('usuario')->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


// Obtener las pistas de la pista 1 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

// Obtener las pistas de la pista 2 ordenadas por fecha, hora de inicio y número de pista
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();


        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));

    }

    public function mostrarPista1(){
        $Pista1 = Pista::where('pista', 1)->where('estado', 0)->get();
        return view("pistas.index", compact("Pista1"));
    }

    public function mostrarPista2(){
        $Pista2 = Pista::where('pista', 2)->where('estado', 0)->get();
        return view("pistas.index", compact("Pista2"));
    }

    public function reservarPista($id_pista) {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {
            // Obtener el ID de usuario
            $id_usuario = Auth::id();

            // Actualizar la pista con el estado y el ID de usuario
            Pista::where('id_pista', $id_pista)->update(['estado' => 1, 'id_usuario' => $id_usuario]);

            // Redireccionar o realizar cualquier otra acción necesaria
            return redirect()->back()->with('info','Mensaje enviado');
        } else {
            // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar una pista.');
        }
    }

    public function mostrarPerfil()
    {
        // Obtener las sesiones de pistas reservadas por el usuario
        $reservasPistas = Pista::where('id_usuario', Auth::id())->get();

        // Obtener las clases reservadas por el usuario
        $reservasClases = Clase::where('id_alumno', Auth::id())->get();

        // Devolver la vista con los datos obtenidos
        return view('perfil', compact('reservasPistas', 'reservasClases'));
    }

    public function cancelarReserva($id)
    {
        $pista = Pista::findOrFail($id);
        $pista->id_usuario = null;
        $pista->estado = 0;
        $pista->save();

        $userId = Auth::id();

        // Obtener las sesiones de pistas reservadas por el usuario
        $reservasPistas = Pista::where('id_usuario', Auth::id())->get();

        // Obtener las clases reservadas por el usuario
        $reservasClases = Clase::where('id_alumno', Auth::id())->get();

        // Devolver la vista con los datos obtenidos
        return view('perfil', compact('reservasPistas', 'reservasClases'));
    }

    public function generarPista1Automatico()
    {
        // Obtener la fecha actual
        $fechaActual = Carbon::now();


        // Iterar para los próximos 5 días
        for ($i = 0; $i < 5; $i++) {
            // Clonar la fecha actual para evitar modificarla
            $fechaActualIteracion = $fechaActual->copy();

            // Obtener la fecha para el día actual más $i días
            $fecha = $fechaActualIteracion->addDays($i)->format('Y-m-d');

            // Generar las horas de inicio y fin para cada pista
            $horaInicioPista1 = Carbon::parse('09:00');

            // Iterar para cada pista
            for ($horaInicioPista1; $horaInicioPista1->lessThanOrEqualTo(Carbon::parse('21:00')); $horaInicioPista1->addHours(1)->addMinutes(30)) {
                $horaFinPista1 = $horaInicioPista1->copy()->addHours(1)->addMinutes(30);

                $pistasExistente = Pista::where('fecha', $fecha)
                    ->where('hora_inicio', $horaInicioPista1->format('H:i'))
                    ->where('pista', 1)
                    ->exists();

                if (!$pistasExistente) {
                    // Crear una nueva pista
                    $pista = new Pista();
                    $pista->estado = 0;
                    $pista->pista = 1;
                    $pista->fecha = $fecha;
                    $pista->hora_inicio = $horaInicioPista1->format('H:i');
                    $pista->hora_fin = $horaFinPista1->format('H:i');
                    $pista->save();
                }
            }
        }

        /*
        $pistas = Pista::all();
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->get();
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->get();

        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));*/
    }


    public function generarPista2Automaticas()
    {
        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Iterar para los próximos 5 días
        for ($i = 0; $i < 5; $i++) {
            // Clonar la fecha actual para evitar modificarla
            $fechaActualIteracion = $fechaActual->copy();

            // Obtener la fecha para el día actual más $i días
            $fecha = $fechaActualIteracion->addDays($i)->format('Y-m-d');

            // Generar las horas de inicio y fin para cada pista
            $horaInicioPista2 = Carbon::parse('09:00');

            // Iterar para cada pista
            for ($horaInicioPista2; $horaInicioPista2->lessThanOrEqualTo(Carbon::parse('21:00')); $horaInicioPista2->addHours(1)->addMinutes(30)) {

                $horaFinPista2 = $horaInicioPista2->copy()->addHours(1)->addMinutes(30);

                $pistasExistente = Pista::where('fecha', $fecha)
                    ->where('hora_inicio', $horaInicioPista2->format('H:i'))
                    ->where('pista', 2)
                    ->exists();

                if (!$pistasExistente) {
                    // Crear una nueva pista
                    $pista = new Pista();
                    $pista->estado = 0;
                    $pista->pista = 2;
                    $pista->fecha = $fecha;
                    $pista->hora_inicio = $horaInicioPista2->format('H:i');
                    $pista->hora_fin = $horaFinPista2->format('H:i');
                    $pista->save();
                }
            }
        }
        /*
        $pistas = Pista::all();
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->get();
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->get();

        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));*/
    }



    public function eliminarPistasAnteriores()
    {
        // Obtener la fecha actual del sistema
        $fechaActual = Carbon::now()->format('Y-m-d');
        $horaActual = Carbon::now()->format('H:i');

        // Obtener las pistas con estado igual a 0, fecha anterior a la fecha actual y hora_inicio anterior a la hora actual
        $pistas = Pista::where('estado', '0')
            ->where('fecha', '<', $fechaActual)
            ->orWhere(function ($query) use ($fechaActual, $horaActual) {
                $query->where('fecha', $fechaActual)
                    ->where('hora_inicio', '<', $horaActual);
            })
            ->whereNull('id_usuario')
            ->get();

        // Eliminar las pistas encontradas
        foreach ($pistas as $pista) {
            $pista->delete();
        }
    }


}
