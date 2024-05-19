@extends('layouts.layout')



@section('contenido')

    <h1>Editar Usuario</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">

        @csrf

        @method('PATCH')

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div>
            <label for="rol">Rol:</label>
            <input type="number" min="1" max="3" id="rol" name="rol" value="{{ $user->rol }}">
        </div>

        <button type="submit">Actualizar</button>

    </form>

@endsection
