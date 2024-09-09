<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Models\Bookmark;
use App\Models\Feedback;
use Carbon\Carbon;

class BookmarkController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.bookmark');
			$this->bookmarks = Bookmark::select('bookmarks.*')->with(['listing' , 'user'])
            ->join('listings', 'listings.id', 'bookmarks.listing_id')
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
                                ->whereDate('listing_budget_date.date_time', '>', Carbon::now())
                                ->where('bookmarks.user_id', $this->user->id)
                                ->where('listing_budget_date.status','!=', 'completed')
                                ->whereNull('people_id')
								->groupby('listings.id')
                                ->get();
        $this->peoples = Bookmark::with(['listing', 'people' => function($q) {
            $q->with('specialties','specialties.specialty');
            }])
            ->where('user_id', $this->user->id)
            ->whereNull('listing_id')
            ->get();
			// echo "<pre>";
			// print_r($this->bookmarks[0]);
			// die();
        return view('user/bookmark/view', $this->data);
    }

    public function destroy($id)
    {
        Bookmark::destroy($id);
        return Reply::success(__('messages.bookmarkDeleted'));
    }
}
