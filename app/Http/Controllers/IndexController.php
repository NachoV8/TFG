<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Torneo;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $profesores = User::where('rol', 2)->get();

        $clasesLibres = Clase::whereIn('id_profesor', $profesores->pluck('id'))
            ->where('id_alumno', null)
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->take(3)
            ->with('alumno', 'profesor')
            ->get();

        $fechaActual = now()->toDateString();

        // Obtener los dos torneos más cercanos a la fecha actual
        $torneosCercanos = Torneo::orderByRaw("ABS(DATEDIFF(hora_inicio, '$fechaActual'))")
            ->take(2)
            ->whereRaw('inscritos < cant_max')
            ->get();

        return view('index', compact('clasesLibres','torneosCercanos'));
    }
}
