<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestRequest extends FormRequest
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
            'client_phone' => 'required',
            'type' => 'required|integer',
            'layout_id' => 'required_if:type,1|integer|exists:layouts,id',
            'residential_complex_id' => 'required_if:type,4|integer|exists:residential_complexes,id'
        ];
    }
}
