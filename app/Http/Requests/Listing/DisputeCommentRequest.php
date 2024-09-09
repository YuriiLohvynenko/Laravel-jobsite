<?php

namespace App\Http\Requests\Listing;

use App\Http\Requests\CoreRequest;

class DisputeCommentRequest extends CoreRequest
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
        $rules = [];
        if(is_null($this->file('image')[0]) && is_null($this->get('text'))){
            $rules['text'] = ['required'];
        }

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
