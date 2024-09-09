<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'subject', 'message'];
}
