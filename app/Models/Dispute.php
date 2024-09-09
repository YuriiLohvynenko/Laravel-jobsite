<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $table = 'disputes';
    protected $dates = ['created_at', 'cancellation_time'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function Listing (){
        return $this->belongsTo(Listing::class);
    }
    public function chat()
    {
        return $this->hasMany(DisputeChat::class, 'dispute_id', 'id');
    }
}
