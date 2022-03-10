<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateUpdateRequest extends FormRequest
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
            'first_name'=>'sometimes|string',
            'last_name'=>'sometimes|string',
            'position'=>'sometimes|string',
            'min_salary'=> 'sometimes|integer',
            'max_salary'=> 'sometimes|integer',
            'linkedin'=> 'sometimes|string',
        ];
    }
}
