<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function people(){
        return $this->belongsTo(User::class, 'people_id');
    }

    public function listing(){
        return $this->belongsTo(Listing::class);
    }
}
