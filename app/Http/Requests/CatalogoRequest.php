<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CatalogoRequest extends FormRequest
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
                'interes' => ['required' , Rule::in(['SIMPLE', 'COMPUESTO'])],
                'porcentaje' => 'required|string|max:18|min:1|regex:/^\d{1,2}(\.\d{1,16})?$/',
                'num_plazoDevolucion' => 'required|integer|between:0,31',
                'time_plazoDevolucion' => ['required', Rule::in(['DIAS', 'MES', 'MESES', 'ANIO', 'ANIOS']) ],
                'no_cobranza' => ['required', Rule::in(['NINGUNO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'SABADO','DOMINGO'])],
                'tarifa_cargos' => 'required|regex:/^\$[d{1,4})(\.\d{1,2}]/',

         ];
    }
}
