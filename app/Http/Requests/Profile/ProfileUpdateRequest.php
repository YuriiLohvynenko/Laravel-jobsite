<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\CoreRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileUpdateRequest extends CoreRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'paypal_email' => ['required', 'string', 'email', 'max:255'],
            'hourly_rate' => ['required', 'string', 'max:255'],
            'speciality' => ['required'],
//            'previous_job_titles' => ['required', 'string', 'max:255'],
            'profileIntroduction' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip_code' => ['required'],
            'mobile_no' => ['required'],
        ];

        if($this->get('new_password') != null){
//            Validator::extend('check_old_password', function($attribute, $value, $parameters)
//            {
//                $user = auth()->guard('job-seeker')->user();
//                if(Hash::check($value, $user->password)) {
//                    return true;
//                }
//                return false;
//            });
            $rules['new_password'] = ['required','min:6', 'confirmed'];
//            $rules['current_password'] = ['required','min:6', 'check_old_password'];
        }
        return $rules;
    }

    public function messages()
    {
        return
        [
            'current_password.check_old_password' => 'New password not match with current password'
        ];
    }
}
