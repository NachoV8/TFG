<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
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


Route::get('/', function () {
    return view('index');
});

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

Route::post('clases/{id_clase}', [ClaseController::class, 'reservarClase'])->name('reservar.clase');

Route::get('pistas', [PistaController::class, 'index'])->name('pistas.index');


//Route::post('sesiones/reservar/{id_pista}', [SesionController::class, 'reservarSesion'])->name('sesiones.reservar');

Route::post('pistas/reservar/{id_pista}', [PistaController::class, 'reservarPista'])->name('pistas.reservar');

/*Route::get('/pistas', function () {
    $controller = app()->make(PistaController::class);
    $controller->generarPista1Automatico();
    $controller->generarPista2Automaticas();
    $controller->eliminarPistasAnteriores();
})->name('pistas.automaticas');*/





Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.mostrar');


Route::patch('/perfil/{id}', [ProfileController::class, 'cancelar'])->name('perfil.cancelar');




Route::resource('productos', ProductoController::class);




//Prueba envio correo laravel

/*Route::get('contactos', function (){
    Mail::to('nachotrzn8@gmail.com')
        ->send(new ContactosMail);

    return "mensaje enviado";

})->name('contactos');*/


Route::get('contactos', [ContactanosController::class, 'index'])->name('sobre-nosotros');

Route::post('contactos', [ContactanosController::class, 'store'])->name('contactos.store');


/*Route::get('/', function () {
    return view('main');
})->middleware(['auth', 'verified'])->name('main');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
