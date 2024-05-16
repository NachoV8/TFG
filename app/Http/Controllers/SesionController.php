<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use App\Http\Requests\StoreSesionRequest;
use App\Http\Requests\UpdateSesionRequest;
use Illuminate\Support\Facades\Auth;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sesiones = Sesion::orderBy('fecha', 'asc')->get();

        $sesionesPista1 = Sesion::where('pista', 1)->where('estado', 0)->get();
        $sesionesPista2 = Sesion::where('pista', 2)->where('estado', 0)->get();

        return view("sesiones.index", compact("sesiones", "sesionesPista1", "sesionesPista2"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("sesiones.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSesionRequest $request)
    {
        $datos = $request->input();
        $sesion = new Sesion($datos);
        $sesion->save();
        $sesiones = Sesion::all();

        $sesionesPista1 = Sesion::where('pista', 1)->where('estado', 0)->get();
        $sesionesPista2 = Sesion::where('pista', 2)->where('estado', 0)->get();

        return view("sesiones.index", compact("sesiones", "sesionesPista1", "sesionesPista2"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Sesion $sesion)
    {
        return view("sesiones.edit", compact("sesion"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sesion $sesion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSesionRequest $request, Sesion $sesion)
    {
        $sesion->update($request->input());//se ejecuta el update
        $sesiones = Sesion::orderBy('fecha', 'asc')->get();

        $sesionesPista1 = Sesion::where('pista', 1)->where('estado', 0)->get();
        $sesionesPista2 = Sesion::where('pista', 2)->where('estado', 0)->get();

        return view("sesiones.index", compact("sesiones", "sesionesPista1", "sesionesPista2"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sesion $sesion)
    {
        $sesion->delete();
        $sesiones = Sesion::all();
        return view("sesiones.index", compact("sesiones"));
    }

    public function reservarSesion($id_sesion) {
        // Verificar si el usuario está autenticado
        if(Auth::check()) {
            // Obtener el ID de usuario
            $id_usuario = Auth::id();

            // Actualizar la pista con el estado y el ID de usuario
            Sesion::where('id_sesion', $id_sesion)->update(['estado' => 1, 'id_usuario' => $id_usuario]);

            // Redireccionar o realizar cualquier otra acción necesaria
            return redirect()->back()->with('success', 'Pista reservada correctamente.');
        } else {
            // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar una pista.');
        }
    }

    public function sesionesReservadasUsuario()
    {
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Obtener las reservas del usuario logueado
        $reservas = Sesion::where('id_usuario', $userId)->get();

        // Retornar la vista con las reservas
        return view('perfil', compact('reservas'));
    }

    public function cancelarReserva($id)
    {
        $sesion = Sesion::findOrFail($id);
        $sesion->id_usuario = null;
        $sesion->estado = 0;
        $sesion->save();

        $userId = Auth::id();

        // Obtener las reservas del usuario logueado
        $reservas = Sesion::where('id_usuario', $userId)->get();

        // Redireccionar a la página de perfil o a donde desees después de cancelar la reserva
        return view('perfil', compact('reservas'));
    }

}
