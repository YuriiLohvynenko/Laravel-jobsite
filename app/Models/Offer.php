<?php

namespace App\Models;

use App\Observers\OfferObserver;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Offer extends Model
{
    use Notifiable;
    protected $table = 'offers';

    public static function boot()
    {
        parent::boot();

        static::observe(OfferObserver::class);

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function listing(){
        return $this->belongsTo(Listing::class);
    }
}
