<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Models\ListingTextAlert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TextAlertController extends BaseController
{
    public function store(Request $request)
    {
        $textAlert = new ListingTextAlert();
        $textAlert->user_id = $this->user->id;
        $textAlert->alert = 1;
        $textAlert->listing_type = $request->type;
        $textAlert->save();

        return Reply::success('Text alert successfully activated');
    }

    public function delete(Request $request)
    {
        ListingTextAlert::where('listing_type', $request->type)->delete();

        return Reply::success('Text alert successfully deactivated');
    }
}
