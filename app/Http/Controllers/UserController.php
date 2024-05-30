<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Inscripcion;
use App\Models\Pista;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view('users.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'rol' => 'required|integer|in:1,2', // Suponiendo que 1 es Usuario y 2 es Profesor
        ]);

        // Crear un nuevo usuario
        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Cifrar la contraseña
        $user->rol = $request->input('rol');

        // Guardar el usuario en la base de datos
        $user->save();

        return redirect()->route('perfil');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        //return view('users.edit', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view('users.edit', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'rol' => 'required|integer',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->rol = $request->input('rol');
        $user->save();

        return redirect()->route('perfil');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(User $user)
    {

        if ($user->rol == 1) {
            // Eliminar reservas de pistas
            $reservasPistas = Pista::where('id_usuario', $user->id)->get();
            foreach ($reservasPistas as $reservaPista) {
                app(PistaController::class)->cancelarReserva($reservaPista->id_pista);
            }

            // Eliminar reservas de clases
            $reservasClases = Clase::where('id_alumno', $user->id)->get();
            foreach ($reservasClases as $reservaClase) {
                app(ClaseController::class)->cancelarClase($reservaClase->id_clase);
            }

            // Eliminar inscripciones a torneos
            $inscripcionesTorneos = Inscripcion::where('id_usuario', $user->id)->get();
            foreach ($inscripcionesTorneos as $inscripcionTorneo) {
                app(ProfileController::class)->cancelarInscripcionTorneo($inscripcionTorneo);
            }

            // Eliminar reservas de productos
            $reservasProductos = Reserva::where('id_usuario', $user->id)->get();
            foreach ($reservasProductos as $reservaProducto) {
                app(ReservaController::class)->cancelarReservaProducto($reservaProducto);
            }

            // Eliminar el usuario
            $user->delete();

            return redirect()->route('perfil');
        } else {

            // Eliminar reservas de pistas
            $reservasPistas = Pista::where('id_usuario', $user->id)->get();
            foreach ($reservasPistas as $reservaPista) {
                app(PistaController::class)->cancelarReserva($reservaPista->id_pista);
            }

            //Eliminar las clases que tenga el profesor
            $clasesProfesor = Clase::where('id_profesor', $user->id)->get();
            foreach ($clasesProfesor as $clase) {
                app(ClaseController::class)->destroy($clase);
            }

            // Eliminar reservas de clases
            $reservasClases = Clase::where('id_alumno', $user->id)->get();
            foreach ($reservasClases as $reservaClase) {
                app(ClaseController::class)->cancelarClase($reservaClase->id_clase);
            }

            // Eliminar inscripciones a torneos
            $inscripcionesTorneos = Inscripcion::where('id_usuario', $user->id)->get();
            foreach ($inscripcionesTorneos as $inscripcionTorneo) {
                app(ProfileController::class)->cancelarInscripcionTorneo($inscripcionTorneo);
            }

            // Eliminar reservas de productos
            $reservasProductos = Reserva::where('id_usuario', $user->id)->get();
            foreach ($reservasProductos as $reservaProducto) {
                app(ReservaController::class)->cancelarReservaProducto($reservaProducto);
            }

            $user->delete();

            return redirect()->route('perfil');
        }
    }
}


