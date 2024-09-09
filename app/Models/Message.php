<?php

namespace App\Models;

use App\Observers\MessageObserver;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $table = 'messages';
    protected $dates = ['date', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        static::observe(MessageObserver::class);

    }

    public function fromuser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function touser(){
        return $this->belongsTo(User::class, 'to_user');
    }

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }

    public static function messageSeenUpdate($loginUser, $toUser, $updateData){
        return Message::where('user_id', $toUser)->where('to_user', $loginUser)->update($updateData);
    }

    public static function allMessageSeenUpdate($loginUser, $updateData){
        return Message::where('to_user', $loginUser)->update($updateData);
    }

}
