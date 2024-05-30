<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Clase;
use App\Models\Inscripcion;
use App\Models\Pista;
use App\Models\Reserva;
use App\Models\Torneo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        if (Auth::check() && Auth::user()->rol == 3)
        {
            $profesores = User::where('rol', 2)->get();
            $usuarios = User::where('rol', 1)->get();

            return view('perfil', compact('profesores','usuarios'));
        } else {
            $this->actualizarReservasPasadas();

            $reservasPistas = Pista::where('id_usuario', Auth::id())->get();
            $reservasTorneo = Inscripcion::where('id_usuario', Auth::id())->get();
            $reservasClases = Clase::where('id_alumno', Auth::id())->get();
            $reservasProductos = Reserva::where('id_usuario', Auth::id())->get();

            return view('perfil', compact('reservasPistas','reservasTorneo', 'reservasClases','reservasProductos'));
        }
    }



    public function edit(Request $request)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view('profile.edit', [
                'user' => $request->user(),
            ]);
        }
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }



    // Funcion para cancelar Pista y/o Clase de un usuario
    public function cancelar($id)
    {
        $esPista = Pista::where('id_pista', $id)->exists();
        $esClase = Clase::where('id_clase', $id)->exists();

        if ($esPista) {
            // Llamar al método de cancelar reserva en PistaController
            return app()->make(PistaController::class)->cancelarReserva($id);
        } elseif ($esClase) {
            // Llamar al método de cancelar clase en ClaseController
            return app()->make(ClaseController::class)->cancelarClase($id);
        } else {
            // Manejar el caso en que no se encuentre ni pista ni clase con ese ID
            return abort(404);
        }
    }


    // Cancelar inscripcion a Torneo
    public function cancelarInscripcionTorneo(Inscripcion $inscripcion)
    {
        $torneo = Torneo::find($inscripcion->id_torneo);

        if ($torneo) {
            $torneo->inscritos -= 1;
            $torneo->save();
        }

        $inscripcion->delete();

        return redirect()->route('perfil');
    }



    // Actualizar las reservas para eliminar las anteriores a la fecha actual
    public function actualizarReservasPasadas()
    {
        // Obtener el usuario logueado
        $user = Auth::user();
        $userId = $user->id;

        // Obtener la fecha y hora actual
        $fecha_actual = Carbon::now();

        // Obtener todas las reservas del usuario logueado que ya han pasado
        $reservasPasadas = Pista::where('id_usuario', $userId)
            ->where(function($query) use ($fecha_actual) {
                $query->where('fecha', '<', $fecha_actual->toDateString())
                    ->orWhere(function($query) use ($fecha_actual) {
                        $query->where('fecha', '=', $fecha_actual->toDateString())
                            ->where('hora_fin', '<', $fecha_actual->toTimeString());
                    });
            })
            ->get();

        $numPartidosPasados = $reservasPasadas->count();

        if ($numPartidosPasados > 0) {
            $user->num_partidos += $numPartidosPasados;
            $user->save();

            // Eliminar las reservas y las sesiones correspondientes
            foreach ($reservasPasadas as $reserva) {
                // Obtener todas las clases que referencian esta reserva de pista
                $clases = Clase::where('id_pista', $reserva->id_pista)->get();

                // Eliminar todas las clases que referencian esta reserva de pista
                foreach ($clases as $clase) {
                    $clase->delete();
                }

                // Actualizar el estado de la reserva de pista
                $reserva->id_usuario = null;
                $reserva->estado = 0;

                // Eliminar la reserva de pista
                $reserva->delete();
            }
        }
    }
}
