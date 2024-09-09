<?php

namespace App\Http\Requests\Listing;

use App\Http\Requests\CoreRequest;

class DisputeCreateRequest extends CoreRequest
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
            'reason' => ['required'],
            'text' => ['required'],
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
