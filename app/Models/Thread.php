<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    use SoftDeletes;
    protected $table = 'threads';
    protected $dates = ['created_at', 'updated_at'];

    public function fromuser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function touser(){
        return $this->belongsTo(User::class, 'to_user');
    }

    public function listing(){
        return $this->hasOne(Listing::class, 'id','listing_id');
    }

}
