<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'username' => 'required|string|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
            'role' => ['required', Rule::in(['SuperUser','Prestamista','Administrador','Cobrador']),]
        ];
    }
}
