<?php

namespace App\Observers;

use App\Models\Listing;
use App\Models\Offer;

class OfferObserver
{
    public function saved(Offer $offer)
    {
        if($offer->isDirty('status') && $offer->isDirty('status') == 'accepted') {
            $listing = Listing::find($offer->listing_id);
            $listing->status = $offer->status;
            $listing->assigned = 'yes';
            $listing->save();
        }
    }
}
