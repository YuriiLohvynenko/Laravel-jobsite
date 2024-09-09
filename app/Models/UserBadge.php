<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    public function documentUrl() {
        if($this->file) {
            return asset('storage/documents/'.$this->file);
        }
        return false;
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
