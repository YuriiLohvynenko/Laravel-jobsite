<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;
    protected $table = 'feedbacks';
    protected $dates = ['created_at'];

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
