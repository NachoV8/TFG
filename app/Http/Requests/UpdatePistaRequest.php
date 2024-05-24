<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePistaRequest extends FormRequest
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
            'estado' => 'required|numeric|min:0|max:1',
            'pista' => 'required|numeric|min:1|max:2',
            'fecha' => 'required|date_format:Y-m-d',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ];
    }
}
