<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('cantidad', '>', 0)->get();

        $productosAll = Producto::all();

        $reservas = Reserva::all();

        return view("productos.index", compact("productos", "productosAll","reservas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            $tiposProductos = [
                'pala' => 'palas',
                'pelota' => 'pelotas',
                'grip' => 'grips',
                'cinta' => 'cintas',
                'mochila' => 'mochilas',
            ];

            return view('productos.create', compact('tiposProductos'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        $datos = $request->input();
        $producto = new Producto($datos);

        $producto->save();

        return redirect()->route('productos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        if (!(Auth::check() && Auth::user()->rol == 3)) {
            return redirect()->route('inicio');
        } else {
            $tiposProductos = [
                'pala' => 'palas',
                'pelota' => 'pelotas',
                'grip' => 'grips',
                'cinta' => 'cintas',
                'mochila' => 'mochilas',
            ];

            return view("productos.edit", compact("producto", 'tiposProductos'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto->update($request->input());

        return redirect()->route('productos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {

        $reservasProductos = Reserva::where('id_producto', $producto->id_producto)->get();

        // Eliminar todas las reservas de este producto
        foreach ($reservasProductos as $reservaProducto) {
            app(ReservaController::class)->cancelarReservaProducto($reservaProducto);
        }

        $producto->delete();

        return redirect()->route('productos');
    }


}
