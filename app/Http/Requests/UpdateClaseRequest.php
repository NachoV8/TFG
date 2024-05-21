<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_profesor' => 'required|exists:users,id',
            'id_pista' => 'required|exists:pistas,id_pista',
            'id_alumno' => 'nullable|exists:alumnos,id', // Suponiendo que existe una tabla de alumnos
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ];
    }
}
