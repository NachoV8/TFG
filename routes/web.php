<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\PistaController;
use \App\Http\Controllers\ClaseController;
use App\Http\Controllers\ProductoController;
use \App\Http\Controllers\SesionController;
use \App\Mail\ContactosMail;
use \App\Http\Controllers\ContactanosController;


Route::get('/', [IndexController::class, 'index'])->name('inicio');

Route::get('/sobre-nosotros', function () {
    return view('sobre-nosotros');
});

Route::get('/perfil', function () {
    return view('perfil');
})->middleware(['auth', 'verified'])->name('perfil');

Route::get('/login', function () {
    return view('login');
});

Route::get('/singin', function () {
    return view('singin');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');



Route::resource('users', UserController::class);

Route::resource('torneos', TorneoController::class);

Route::resource('pistas', PistaController::class);

Route::resource('sesiones', SesionController::class);

Route::resource('clases', ClaseController::class);

Route::resource('productos', ProductoController::class);

Route::resource('reservas', ReservaController::class);



Route::post('productos/reservar/{producto}', [ReservaController::class, 'reservarProducto'])->name('productos.reservar');

Route::post('clases/{id_clase}', [ClaseController::class, 'reservarClase'])->name('reservar.clase');

Route::post('pistas/reservar/{id_pista}', [PistaController::class, 'reservarPista'])->name('pistas.reservar');

Route::post('torneos/reservar/{id_torneo}', [TorneoController::class, 'reservarTorneo'])->name('torneos.reservar');



Route::get('/pistas', [PistaController::class, 'index'])->name('pistas');

Route::get('/clases', [ClaseController::class, 'index'])->name('clases');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');

Route::get('/torneos', [TorneoController::class, 'index'])->name('torneos');



Route::get('/perfil', [ProfileController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('perfil');


Route::patch('/perfil/{id}', [ProfileController::class, 'cancelar'])->name('perfil.cancelar');



Route::delete('perfil/reserva/cancelar/{inscripcion}', [ProfileController::class, 'cancelarInscripcionTorneo'])->name('inscripcion.torneo.cancelar');

Route::delete('productos/reserva/cancelar/{reserva}', [ReservaController::class, 'cancelarReservaProducto'])->name('reserva.producto.cancelar');

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');



Route::get('contactos', [ContactanosController::class, 'index'])->name('sobre-nosotros');

Route::post('contactos', [ContactanosController::class, 'store'])->name('contactos.store');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Ruta para eliminar un usuario específico
});



require __DIR__.'/auth.php';
