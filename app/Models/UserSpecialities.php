<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserSpecialities extends Model
{
    protected $table = 'user_specialities';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function specialty (){
        return $this->belongsTo(Specialities::class, 'speciality_id');
    }
}
