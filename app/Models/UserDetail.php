<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'user_specialities_id',
        'paypal_email',
        'hourly_rate',
        'previous_job_titles',
        'introduction',
        'address',
        'latitude',
        'longitude',
        'city',
        'state',
        'mobile_no',
        'mobile_verification_code',
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
