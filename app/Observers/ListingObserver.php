<?php

namespace App\Observers;

use App\Models\Listing;

class ListingObserver
{
    public function created(Listing $listing) {
        $listing->order_no = $listing->id.str_random(3);
        $listing->save();
    }
}
