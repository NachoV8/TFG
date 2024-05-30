<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Pista;
use App\Http\Requests\StorePistaRequest;
use App\Http\Requests\UpdatePistaRequest;
use App\Models\Torneo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;


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

        $pistas = Pista::with('usuario')->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();
        $pistasPista1 = Pista::where('pista', 1)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();
        $pistasPista2 = Pista::where('pista', 2)->where('estado', 0)->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')->get();

        return view("pistas.index", compact("pistas", "pistasPista1", "pistasPista2"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view("pistas.create");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePistaRequest $request)
    {
        $correoUsuario = $request->input('usuario');

        $idUsuario = null;

        if (!empty($correoUsuario)) {
            $usuario = User::where('email', $correoUsuario)->first();

            if (!$usuario) {
                return redirect()->back()->with('error', 'El correo electrónico proporcionado no corresponde a ningún usuario.');
            }

            $idUsuario = $usuario->id;
        }

        $datos = $request->validated();

        $datos['id_usuario'] = $idUsuario;

        // Verificar si ya existe una pista con los mismos detalles
        $pistaExistente = Pista::where('fecha', $datos['fecha'])
            ->where('hora_inicio', $datos['hora_inicio'])
            ->where('hora_fin', $datos['hora_fin'])
            ->exists();

        // Si ya existe una pista con los mismos detalles, redirigir de vuelta con un mensaje de error
        if ($pistaExistente) {
            return redirect()->back()->with('error', 'Ya existe una pista con la misma fecha, hora de inicio y hora de fin.');
        }

        // Crear y guardar la nueva pista
        $pista = new Pista($datos);
        $pista->save();

        return redirect()->route('pistas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pista $pista)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view("pistas.edit", compact("pista"));
        }
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
        try {
            if (empty($request->input('id_usuario'))) {
                $pista->id_usuario = null;
            } else {
                $usuario = User::where('email', $request->input('id_usuario'))->firstOrFail();
                $pista->id_usuario = $usuario->id;
            }

            $pista->update([
                'estado' => $request->input('estado'),
                'pista' => $request->input('pista'),
                'fecha' => $request->input('fecha'),
                'hora_inicio' => $request->input('hora_inicio'),
                'hora_fin' => $request->input('hora_fin'),
            ]);

            return redirect()->route('pistas');

        } catch (ModelNotFoundException $exception) {
            // Si el correo electrónico proporcionado no existe, mostrar un mensaje de error
            return back()->withErrors(['error' => 'El correo electrónico proporcionado no existe']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pista $pista)
    {

        if ($pista->clase) {
            $pista->clase->delete();
        }
        $pista->id_usuario = null;
        $pista->estado = 0;

        $pista->save();

        $pista->delete();

        return redirect()->route('pistas');
    }



    // Funcion para que un usuario reserve pista
    public function reservarPista($id_pista) {
        if(Auth::check()) {
            $id_usuario = Auth::id();

            $pista = Pista::find($id_pista);
            $fecha_reserva = $pista->fecha;

            $reservas_usuario = Pista::where('id_usuario', $id_usuario)
                ->where('fecha', $fecha_reserva)
                ->count();

            $limite_reservas = 2; // Define el límite de reservas por dia
            if ($reservas_usuario >= $limite_reservas) {
                return redirect()->back()->with('errorLimite', 'Has alcanzado el límite de reservas para esta fecha.');
            }

            Pista::where('id_pista', $id_pista)->update(['estado' => 1, 'id_usuario' => $id_usuario]);

            return redirect()->back()->with('info','Mensaje enviado');
        } else {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar una pista.');
        }
    }


    // Funcion para que un usuario cancele una reserva de pista
    public function cancelarReserva($id)
    {
        $pista = Pista::findOrFail($id);
        $pista->id_usuario = null;
        $pista->estado = 0;
        $pista->save();

        return redirect()->route('perfil');
    }


    // Funcion para generar pistas automaticas para los próximos 5 días
    public function generarPista1Automatico()
    {
        // Obtener la fecha actual
        $fechaActual = Carbon::now();


        // Iterar para los próximos 5 días
        for ($i = 0; $i < 5; $i++) {
            $fechaActualIteracion = $fechaActual->copy();

            $fecha = $fechaActualIteracion->addDays($i)->format('Y-m-d');

            $horaInicioPista1 = Carbon::parse('09:00');

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
    }


    // Funcion para generar pistas automaticas para los próximos 5 días
    public function generarPista2Automaticas()
    {
        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        for ($i = 0; $i < 5; $i++) {
            $fechaActualIteracion = $fechaActual->copy();

            $fecha = $fechaActualIteracion->addDays($i)->format('Y-m-d');

            $horaInicioPista2 = Carbon::parse('09:00');

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
    }



    // Funcion para eliminar las pistas anteriores a la fecha actual de manera automatica
    public function eliminarPistasAnteriores()
    {
        // Obtener la fecha actual del sistema
        $fechaActual = Carbon::now()->format('Y-m-d');
        $horaActual = Carbon::now()->format('H:i');

        // Obtener las pistas con estado igual a 0, fecha anterior a la fecha actual y hora_inicio anterior a la hora actual
        $pistas = Pista::where('estado', '0')
            ->where(function ($query) use ($fechaActual, $horaActual) {
                $query->where('fecha', '<', $fechaActual)
                    ->orWhere(function ($query) use ($fechaActual, $horaActual) {
                        $query->where('fecha', $fechaActual)
                            ->where('hora_inicio', '<', $horaActual);
                    });
            })
            ->get();

        foreach ($pistas as $pista) {
            // Si la pista está reservada por un usuario
            if (!is_null($pista->id_usuario)) {
                // Obtener el usuario
                $usuario = User::find($pista->id_usuario);

                if ($usuario) {
                    // Incrementar el número de partidos
                    $usuario->num_partidos += 1;

                    $usuario->save();
                }

                $pista->estado = 0;
                $pista->id_usuario = null;

                $pista->save();
            }

            // Verificar si la pista está asociada a un torneo
            if (!is_null($pista->torneo)) {
                // Obtener el torneo asociado
                $torneo = $pista->torneo;

                // Actualizar todas las pistas asociadas al torneo
                $pistasTorneo = $torneo->pistas;
                foreach ($pistasTorneo as $pistaTorneo) {
                    $pistaTorneo->estado = 0;
                    $pistaTorneo->id_usuario = null;
                    $pistaTorneo->save();
                    // Eliminar las clases asociadas a la pista
                    Clase::where('id_pista', $pistaTorneo->id_pista)->delete();
                    // Finalmente, eliminar la pista
                    $pistaTorneo->delete();
                }

                $torneo->delete();
            } else {
                // Eliminar las clases asociadas a la pista
                Clase::where('id_pista', $pista->id_pista)->delete();

                $pista->delete();
            }

            $pista->delete();
        }
    }
}
