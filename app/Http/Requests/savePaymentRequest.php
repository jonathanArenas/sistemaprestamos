<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class savePaymentRequest extends FormRequest
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
            'num' => 'required',
            'date' => 'required|date',
            'payments' => 'required',
            'payments.id' => 'distinct',
            'total' => 'required|numeric',
            'efectivo' => 'required|numeric|gte:total',
         ];
    }
}
