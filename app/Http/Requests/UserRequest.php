<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nombre'      => 'required|max:50',
            'apellido'      => 'required|max:50',
            'direccion'      => 'required|max:300',
            'documento' => 'required|min:8|max:8',
            'cumpleanos' => 'required',
            'ingreso' => 'required',
            'correo' => 'required|email',
            'phone' => 'max:9',
        ];
    }
}
