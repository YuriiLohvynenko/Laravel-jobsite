<?php

namespace App\Http\Requests\Badges;

use App\Http\Requests\CoreRequest;

class StoreRequest extends CoreRequest
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
        $rule = [];

        if($this->badge_id == 1 || $this->badge_id == 2) {
            $rule = [
                'file' => 'required|mimes:pdf,jpeg,jpg,png',
            ];
        }

        if($this->badge_id == 3) {
            $rule = [
                'package_check' => 'required',
                'job_title' => 'required',
            ];
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];

        return array_merge($rule, $rules);

    }
}
