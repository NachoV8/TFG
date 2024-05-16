<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Clase;
use App\Models\Pista;
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
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
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

    public function cancelar($id)
    {
        // Verificar si el ID pertenece a una pista o a una clase
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
}
