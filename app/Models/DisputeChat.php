<?php

namespace App\Models;

use App\Observers\ListingObserver;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DisputeChat extends Model
{
    protected $table = 'dispute_chat';

    protected $dates = ['created_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function dispute(){
        return $this->belongsTo(Dispute::class);
    }

}
