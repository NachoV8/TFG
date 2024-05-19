<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesores = User::where('rol', 2)->get();

        // Pasar los profesores a la vista
        return view('index', compact('profesores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        return view('users.edit', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $id)
    {

        $id->update($request->input());


        $profesores = User::where('rol', 2)->get();

        // Pasar los profesores a la vista
        return view('index', compact('profesores'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $id)
    {
        $user = User::find($id);
        $user->delete();

        $profesores = User::where('rol', 2)->get();

        return view('index', compact('profesores'));
    }
}
