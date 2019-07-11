<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Foundation\Http\FormRequest;

class QuotationSave extends FormRequest
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
            'id' => 'required',
            'quotation.*.id'            => 'required|integer|min:1',
            'quotation.*.quantity'      => 'required|integer|min:1',
            'quotation.*.unit_price'    => 'numeric',
            'comment'                   => 'nullable|string'
        ];
    }
}
