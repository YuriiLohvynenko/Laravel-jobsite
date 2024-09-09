<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Classes\Reply;

class CoreRequest extends FormRequest
{

    /**
     * CoreRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function formatErrors(\Illuminate\Contracts\Validation\Validator  $validator)
    {
        return Reply::formErrors($validator);
    }

}