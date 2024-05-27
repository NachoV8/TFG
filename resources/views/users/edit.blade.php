@extends('layouts.layout')

@section('contenido')
    <h1>Editar Usuario</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')"/><br>
        </div>


        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}">
            <x-input-error class="mt-2" :messages="$errors->get('email')"/><br>
        </div>


        <div>
            <label for="rol">Rol</label>
            <select name="rol" id="rol" required>
                <option value="1" {{ $user->rol == 1 ? 'selected' : '' }}>Usuario</option>
                <option value="2" {{ $user->rol == 2 ? 'selected' : '' }}>Profesor</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('rol')"/><br>
        </div>


        <button type="submit">Actualizar</button>
    </form>
@endsection
