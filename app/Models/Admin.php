<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public function image($size= 80, $d = 'mm')
    {
        if(is_null($this->attributes['image'])){
           $url = asset('images/user-avatar-placeholder.png');

        }else{
            $url = asset('storage/avatar/'.$this->attributes['image']);
        }

        return $url;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
