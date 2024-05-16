<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use App\Http\Requests\StoreTorneoRequest;
use App\Http\Requests\UpdateTorneoRequest;

class TorneoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Aquí puedes obtener los torneos desde tu modelo Torneo
        $torneos = Torneo::all();

        return view('torneos.index', compact('torneos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('torneos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTorneoRequest $request)
    {
        $datos = $request->input();

        $torneo = new Torneo($datos);
        $torneo->save();
        $torneos = Torneo::all();
        return view("torneos.index",compact("torneos"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Torneo $torneo)
    {
        return view('torneos.edit', compact('torneo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Torneo $torneo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTorneoRequest $request, Torneo $torneo)
    {
        $torneo->update($request->input());//se ejecuta el update
        $torneos = Torneo::all();//se piden todos los alumnos para mostrarlos al redirigir a listado
        return view("torneos.index", compact("torneos"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Torneo $torneo)
    {
        $torneo->delete();
        $torneos = Torneo::all();
        return view("torneos.index  ", compact("torneos"));
    }
}
