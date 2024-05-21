<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reserva;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function reservarProducto(Request $request, Producto $producto)
    {
        if (Auth::check()){
            $request->validate([
                'cantidad' => 'required|integer|min:1',
            ]);

            $cantidad = $request->input('cantidad');

            // Verificar si hay suficiente stock
            if ($producto->cantidad < $cantidad) {
                return redirect()->back()->withErrors(['cantidad' => 'No hay suficiente stock disponible.']);
            }

            // Crear la reserva
            Reserva::create([
                'id_usuario' => Auth::id(),
                'id_producto' => $producto->id_producto,
                'cantidad' => $cantidad,
            ]);

            // Disminuir la cantidad del producto
            $producto->cantidad -= $cantidad;
            $producto->save();

            return redirect()->route('productos');
        }else{
            return redirect()->route('login');
        }
    }
}
