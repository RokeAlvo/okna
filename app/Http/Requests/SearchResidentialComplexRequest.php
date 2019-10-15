<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchResidentialComplexRequest extends FormRequest
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
            'rooms_list' => 'sometimes|nullable|array',
            'rooms_list.*' => 'sometimes|nullable|integer',

            'districts_list' => 'sometimes|nullable|array',
            'districts_list.*' => 'sometimes|nullable|integer',

            'completion_date_range' => 'sometimes|nullable|array',
            'completion_date_range.*' => 'sometimes|nullable|integer',
            /*'completion_date_range.*.completion_decade' => 'sometimes|nullable|in:1,2,3,4',
            'completion_date_range.*.completion_year' => 'sometimes|nullable|integer',*/

            'price_from' => 'sometimes|nullable|integer',
            'price_to' => 'sometimes|nullable|integer',

            'area_from' => 'sometimes|nullable|integer',
            'area_to' => 'sometimes|nullable|integer'
        ];
    }
}
