<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('cantidad', '>', 0)->get();

        $productosAll = Producto::all();

        return view("productos.index", compact("productos", "productosAll"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposProductos = [
            'pala' => 'palas',
            'pelota' => 'pelotas',
            'grip' => 'grips',
            'cinta' => 'cintas',
            'mochila' => 'mochilas',
        ];

        return view('productos.create', compact('tiposProductos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        $datos = $request->input();
        $producto = new Producto($datos);
        $producto->save();

        $productos = Producto::where('cantidad', '>', 0)->get();
        $productosAll = Producto::all();

        return view("productos.index", compact("productos", "productosAll"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view("productos.edit", compact("producto"));
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
        $producto->update($request->input());//se ejecuta el update

        $productos = Producto::where('cantidad', '>', 0)->get();
        $productosAll = Producto::all();

        return view("productos.index", compact("productos", "productosAll"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        $productos = Producto::where('cantidad', '>', 0)->get();
        $productosAll = Producto::all();

        return view("productos.index", compact("productos", "productosAll"));
    }

    public function filtrar(Request $request)
    {
        // Obtener los tipos seleccionados del formulario
        $tiposSeleccionados = $request->input('producto');

        // Filtrar los productos según los tipos seleccionados
        $productosFiltrados = Producto::whereIn('tipo', $tiposSeleccionados)->get();

        // Pasar los productos filtrados a la vista
        return view('productos.index', compact('productosFiltrados'));
    }


}