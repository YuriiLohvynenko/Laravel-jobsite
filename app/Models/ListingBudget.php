<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingBudget extends Model
{
    protected $table = 'listing_budget_date';
    protected $dates = ['date_time'];

    public function shift()
    {
        return $this->hasOne(Shift::class, 'budget_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function increase_history()
    {
        return $this->hasMany(BudgetIncreaseHistory::class, 'listing_budget_date_id');
    }
}
