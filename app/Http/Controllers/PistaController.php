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

        // Obtener todas las pistas ordenadas por fecha
        // Obtener todas las pistas ordenadas por fecha, hora de inicio y número de pista
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
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else{
            return view("pistas.create");
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePistaRequest $request)
    {
        // Obtener el correo electrónico del usuario del formulario
        $correoUsuario = $request->input('usuario');

        // Inicializar id_usuario como null
        $idUsuario = null;

        // Si el correo de usuario no está vacío, buscar al usuario basado en el correo electrónico proporcionado
        if (!empty($correoUsuario)) {
            $usuario = User::where('email', $correoUsuario)->first();

            // Verificar si el usuario existe
            if (!$usuario) {
                return redirect()->back()->with('error', 'El correo electrónico proporcionado no corresponde a ningún usuario.');
            }

            // Asignar el id del usuario encontrado a idUsuario
            $idUsuario = $usuario->id;
        }

        // Obtener los datos del formulario
        $datos = $request->validated();

        // Asignar el id_usuario basado en el correo proporcionado o null si está vacío
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
        }else {
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
            // Verificar si el campo id_usuario está vacío
            if (empty($request->input('id_usuario'))) {
                // Si está vacío, establecer el valor de id_usuario como null
                $pista->id_usuario = null;
            } else {
                // Obtener el ID del usuario asociado al correo electrónico proporcionado en el formulario
                $usuario = User::where('email', $request->input('id_usuario'))->firstOrFail();
                // Actualizar el id_usuario de la pista con el ID del usuario obtenido
                $pista->id_usuario = $usuario->id;
            }

            // Actualizar otros campos de la pista
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
            // Eliminar la clase asociada
            $pista->clase->delete();
        }
        // Establecer el id_usuario como null
        $pista->id_usuario = null;
        $pista->estado = 0;
        $pista->save(); // Guardar los cambios en la pista

        $pista->delete();

        return redirect()->route('pistas');

    }


    public function reservarPista($id_pista) {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {
            // Obtener el ID de usuario
            $id_usuario = Auth::id();

            // Obtener la fecha de reserva que el usuario quiere hacer
            $pista = Pista::find($id_pista);
            $fecha_reserva = $pista->fecha;

            // Contar las reservas del usuario para la fecha de reserva deseada
            $reservas_usuario = Pista::where('id_usuario', $id_usuario)
                ->where('fecha', $fecha_reserva)
                ->count();

            // Verificar si el usuario ha alcanzado el límite de reservas para esa fecha
            $limite_reservas = 2; // Define el límite de reservas
            if ($reservas_usuario >= $limite_reservas) {
                // Si el usuario ha alcanzado el límite de reservas, devuelve un mensaje de error
                return redirect()->back()->with('errorLimite', 'Has alcanzado el límite de reservas para esta fecha.');
            }

            // Actualizar la pista con el estado y el ID de usuario
            Pista::where('id_pista', $id_pista)->update(['estado' => 1, 'id_usuario' => $id_usuario]);

            // Redireccionar o realizar cualquier otra acción necesaria
            return redirect()->back()->with('info','Mensaje enviado');
        } else {
            // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar una pista.');
        }
    }


    public function cancelarReserva($id)
    {
        $pista = Pista::findOrFail($id);
        $pista->id_usuario = null;
        $pista->estado = 0;
        $pista->save();

        return redirect()->route('perfil');

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
    }



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

        // Procesar cada pista encontrada
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

                // Cambiar el estado de la pista a 0 y el id_usuario a null
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

                // Eliminar el torneo
                $torneo->delete();
            } else {
                // Eliminar las clases asociadas a la pista
                Clase::where('id_pista', $pista->id_pista)->delete();
                // Finalmente, eliminar la pista
                $pista->delete();
            }

            // Finalmente, eliminar la pista
            $pista->delete();
        }
    }
}
