<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Badges\LicensedBadgesRequest;
use App\Http\Requests\Badges\StoreRequest;
use App\Models\Badge;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\UserBadge;
use App\Notifications\BadgeVerification;
use App\Notifications\ContactUsMail;
use App\Notifications\LicenseBadgeVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TrackJobController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
		$now = Carbon::now();
        $this->pageTitle = trans('menu.trackJobs');

        $this->remoteListings = Listing::select('listings.id','listings.materials','listings.state','listings.city','listings.address','listings.street_address','listings.immediate_assistance','listings.job_location','listings.budget','listings.date_time','listings.user_id','listings.category_id','listings.job_title','listings.description')->with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offers' => function($q) {
                $q->with('user')->where('status', 'accepted');
            }])
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('listing_budget_date.date_time', '>=',$now)
            ->where('listings.job_location', 'online')
            ->where('assigned', 'yes')
            ->where('listings.user_id', $this->user->id)
            ->groupBy('listings.id','listings.materials','listings.state','listings.city','listings.address','listings.street_address','listings.immediate_assistance','listings.job_location','listings.budget','listings.date_time','listings.user_id','listings.category_id','listings.job_title','listings.description');

        $this->onSiteListings = Listing::select('listings.id','listings.materials','listings.state','listings.city','listings.address','listings.street_address','listings.immediate_assistance','listings.job_location','listings.budget','listings.date_time','listings.user_id','listings.category_id','listings.job_title','listings.description')->with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offers' => function($q) {
                $q->with('user')->where('status', 'accepted');
            }])
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->whereDate('listing_budget_date.date_time', '>',$now)
            ->where('listings.job_location', 'on_location')
            ->where('listings.assigned', 'yes')
            ->where('listings.user_id', $this->user->id)
            ->groupBy('listings.id','listings.materials','listings.state','listings.city','listings.address','listings.street_address','listings.immediate_assistance','listings.job_location','listings.budget','listings.date_time','listings.user_id','listings.category_id','listings.job_title','listings.description');

//        dd($this->onSiteListings->get()->first()->offers->user_id);

        $this->type = $request->type;

        if ($request->ajax()) {
            if($request->type == 'onSite') {
                $this->onSiteListings = $this->onSiteListings->skip(($request->page - 1) * 2)->take(2)->paginate(2);
                $this->listings = $this->onSiteListings;
                $view = view('user.track-jobs.list', $this->data)->render();
            }
            else if($request->type == 'remote') {
                $this->remoteListings = $this->remoteListings->skip(($request->page - 1) * 2)->take(2)->paginate(2);
                $this->listings = $this->remoteListings;
                $view = view('user.track-jobs.list', $this->data)->render();
            }

            return Reply::dataOnly(['view' => $view]);
        }

        $this->remoteListingsArr = $this->remoteListings->get();
        $this->onSiteListingsArr = $this->onSiteListings->get();

        $this->onSiteListings = $this->onSiteListings->paginate(2);
        $this->remoteListings = $this->remoteListings->paginate(2);

        return view('user/track-jobs/index', $this->data);
    }


    public function onSiteJobs(Request $request)
    {

    }
}
