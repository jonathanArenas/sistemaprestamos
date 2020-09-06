<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'paterno' => 'required|string',
            'materno' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|max:13|min:10',
            'email' => 'required|email',
            'postal' => 'required|string|max:5',
            'estado' => 'required|string',
            'municipio' => 'required|string',
            'colonia'=> 'required|string',
            'direccion' => 'required|string',
            'num_int' => 'nullable|string',
            'num_ext' => 'required|string',
            'zona' => 'required|string',
            'seccion' => 'required|string',
            'documento_I' => 'required|string|max:2|min:2',
        ];
    }
}
