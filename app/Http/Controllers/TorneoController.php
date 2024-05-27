<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Pista;
use App\Models\Torneo;
use App\Http\Requests\StoreTorneoRequest;
use App\Http\Requests\UpdateTorneoRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TorneoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $torneos = Torneo::orderBy('fecha')->get();

        $torneosDisponibles = Torneo::whereRaw('inscritos < cant_max')->get();

        return view('torneos.index', compact('torneos','torneosDisponibles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else {
            $pistasLibres = Pista::where('estado', 0)
                ->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')
                ->get();

            return view('torneos.create', compact('pistasLibres'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTorneoRequest $request)
    {
        // Validación de datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'premios' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cant_max' => 'required|integer|min:1',
            'pistas' => 'required|array|min:1', // Al menos una pista debe ser seleccionada
            'pistas.*' => 'exists:pistas,id_pista', // Verificar que todas las pistas seleccionadas existan en la tabla pistas
        ]);

        // Crear el torneo
        $torneo = new Torneo();
        $torneo->nombre = $request->nombre;
        $torneo->descripcion = $request->descripcion;
        $torneo->premios = $request->premios;
        $torneo->precio = $request->precio;
        $torneo->cant_max = $request->cant_max;
        // Otros campos del torneo...

        // Obtener la hora de inicio más temprana entre las pistas seleccionadas
        $pistasSeleccionadas = Pista::whereIn('id_pista', $request->pistas)->get();
        $fechaHoraInicioMasTemprana = $pistasSeleccionadas->sortBy('fecha')->sortBy('hora_inicio')->first();
        $fechaInicioMasTemprana = $fechaHoraInicioMasTemprana->fecha;
        $horaInicioMasTemprana = $fechaHoraInicioMasTemprana->hora_inicio;

        // Asignar la hora de inicio más temprana al torneo
        $torneo->hora_inicio = $horaInicioMasTemprana;
        $torneo->fecha = $fechaInicioMasTemprana;

        // Guardar el torneo
        $torneo->save();

        // Actualizar las pistas seleccionadas
        foreach ($pistasSeleccionadas as $pista) {
            // Actualizar el estado y el id_usuario de la pista
            $pista->estado = 1;
            $pista->id_usuario = Auth::id(); // Id del usuario logueado
            $pista->save();
        }

        return redirect()->route('torneos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Torneo $torneo)
    {

        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        }else {
            // Obtener todas las pistas con estado 0
            $pistasDisponibles = Pista::where('estado', 0)
                ->orderBy('fecha')->orderBy('hora_inicio')->orderBy('pista')
                ->get();


            return view('torneos.edit', compact('torneo', 'pistasDisponibles'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Torneo $torneo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTorneoRequest $request, Torneo $torneo)
    {
        // Obtener las pistas asociadas antes de la actualización
        $pistasAntes = $torneo->pistas()->get();

        // Actualizar los datos del torneo
        $torneo->update($request->all());

        // Obtener las pistas asociadas después de la actualización
        $pistasDespues = $torneo->pistas()->get();

        // Identificar las pistas eliminadas
        $pistasEliminadas = $pistasAntes->diff($pistasDespues);

        // Identificar las pistas agregadas
        $pistasAgregadas = $pistasDespues->diff($pistasAntes);

        // Procesar las pistas eliminadas
        foreach ($pistasEliminadas as $pista) {
            // Actualizar el estado y el id_usuario de la pista
            $pista->estado = 0;
            $pista->id_usuario = null;
            $pista->save();
        }

        // Procesar las pistas agregadas
        foreach ($pistasAgregadas as $pista) {
            // Actualizar el estado y el id_usuario de la pista
            $pista->estado = 1;
            $pista->id_usuario = Auth::id(); // ID del usuario logueado
            $pista->save();
        }

        // Redireccionar o devolver una respuesta según sea necesario
        return redirect()->route('torneos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Torneo $torneo)
    {
        $torneo->delete();


        return redirect()->route('torneos');
    }

    public function reservarTorneo($id)
    {

        if(Auth::check()) {

            // Buscar el torneo por su ID
            $torneo = Torneo::findOrFail($id);

            // Verificar si el usuario ya está inscrito en el torneo
            $inscripcionExistente = Inscripcion::where('id_usuario', Auth::id())->where('id_torneo', $torneo->id_torneo)->first();

            if ($inscripcionExistente) {
                return redirect()->back()->with('error', 'Ya estás inscrito en este torneo');
            }

            // Incrementar el contador de inscritos del torneo
            $torneo->inscritos += 1;
            $torneo->save();

            // Crear una nueva inscripción para el usuario en el torneo
            $inscripcion = new Inscripcion();
            $inscripcion->id_usuario = Auth::id();
            $inscripcion->id_torneo = $torneo->id_torneo;
            $inscripcion->save();

            return redirect()->back()->with('info','Inscripción realizada correctamente');
        }else{
            return redirect()->route('login');
        }
    }
}
