<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'invites';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function listing(){
        return $this->belongsTo(Listing::class);
    }

    public function people(){
        return $this->belongsTo(User::class);
    }
}
