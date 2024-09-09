<?php

namespace App\Http\Requests\Listing;

use App\Http\Requests\CoreRequest;

class CreateRequest extends CoreRequest
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
        $rules = [
            'category' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'materials' => ['required'],
            'job_location' => ['required'],
            'address' => ['required', 'string'],
            'street_address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required'],
            'term_condition' => ['required'],
        ];

        return $rules;
    }

    public function messages()
    {
        return
        [
            //
        ];
    }
}
