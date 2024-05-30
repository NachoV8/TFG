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

    public function show(Reserva $reserva)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            return view("reservas.edit", compact("reserva"));
        }
    }

    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        $cantidadAnterior = $reserva->cantidad;

        $request->validate([
            'cantidad' => 'required|integer|min:1|max:' . $reserva->producto->cantidad
        ]);

        $nuevaCantidad = $request->input('cantidad');

        $cantidadStockproducto = $reserva->producto->cantidad;

        if($nuevaCantidad > $cantidadStockproducto){
            return redirect()->back()->with('error', 'Has seleccionado una cantidad mayor a la del stock');
        }else{
            $diferencia = $nuevaCantidad - $cantidadAnterior;

            $reserva->update(['cantidad' => $nuevaCantidad]);

            $producto = $reserva->producto;

            $producto->update(['cantidad' => $producto->cantidad - $diferencia]);

            return redirect()->route('productos');
        }

    }

    public function destroy(Reserva $reserva)
    {
        $cantidadReservada = $reserva->cantidad;

        $reserva->delete();

        $producto = $reserva->producto;
        $producto->cantidad += $cantidadReservada;

        $producto->save();

        return redirect()->route('productos');
    }



    // Funcion para reservar un producto
    public function reservarProducto(Request $request, Producto $producto)
    {
        if (Auth::check()){
            $request->validate([
                'cantidad' => 'required|integer|min:1',
            ]);

            $cantidad = $request->input('cantidad');

            // Verificar si hay suficiente stock
            if ($producto->cantidad < $cantidad) {
                return redirect()->back()->with('errorCant', 'No hay tanto stock disponible');
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

            return redirect()->back()->with('info', '¡Producto reservado correctamente!');
        } else {
            return redirect()->route('login');
        }
    }


    // Funcion para cancelar una reserva de un producto
    public function cancelarReservaProducto(Reserva $reserva)
    {
        $producto = $reserva->producto;
        $producto->cantidad += $reserva->cantidad;
        $producto->save();

        $reserva->delete();

        return redirect()->route('perfil');
    }
}
