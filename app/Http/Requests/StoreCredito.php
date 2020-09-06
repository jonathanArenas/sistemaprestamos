<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCredito extends FormRequest
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
            'id' => 'required|integer',
			'dateRequest' => 'nullable|date',
			'capital' => 'required|numeric|max:999999',
			'interesType' => ['required', Rule::in(['SIMPLE', 'COMPUESTO'])],
			'porcentaje' => 'required|string|max:18|min:1|regex:/^\d{1,2}(\.\d{1,16})?$/',
			'devolucion' => 'required',
			'devolucion.numberPlazo' => 'required|integer|between:0,31',
            'devolucion.timePlazo' => ['required', Rule::in(['DIAS', 'MES', 'MESES', 'ANIO', 'ANIOS'])],
            'no_cobranza' => ['required', Rule::in(['NINGUNO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'SABADO','DOMINGO'])],
            'tarifa_cargos' => 'required|numeric|between:0,9999',
            'cobrador' => 'required|integer',
            'prestamista' => 'required|integer',
        ];
    }
}
