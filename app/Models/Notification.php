<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $appends = ['notification_data'];
    public function getNotificationDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }
}
