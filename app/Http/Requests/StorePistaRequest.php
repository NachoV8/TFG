<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePistaRequest extends FormRequest
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
            'estado' => 'required|numeric|between:0,1',
            'pista' => 'required|numeric|between:1,2',
            'fecha' => 'required|date:format:dd-MM-yyyy',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_usuario' => 'numeric'
        ];
    }
}
