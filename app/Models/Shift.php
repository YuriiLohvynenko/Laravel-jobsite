<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $dates = ['start_date', 'end_date', 'created_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function Listing (){
        return $this->belongsTo(Listing::class);
    }
    public function Budget (){
        return $this->belongsTo(ListingBudget::class, 'budget_id', 'id');
    }
}
