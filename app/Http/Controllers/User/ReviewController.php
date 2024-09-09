<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Review\CreateRequest;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\ListingBudget;
use App\Models\ListingFile;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.listing');

        $this->clients = Listing::selectRaw('listings.*, listings.id as list_id, offers.*,offers.user_id as offer_user_id, offers.status as offer_status')
            ->with(['freelance_client','freelance_client.user',])
            ->join('offers', 'offers.listing_id', 'listings.id')
            ->where('offers.user_id', $this->user->id)
            ->where('offers.status', 'accepted')
            ->get();

        $this->freelancers = Listing::selectRaw('listings.*, listings.id as list_id, offers.*,offers.user_id as offer_user_id, offers.status as offer_status')
            ->with(['freelance_feedback','freelance_feedback.user',])
            ->join('offers', 'offers.listing_id', 'listings.id')
            ->where('listings.id', $this->user->id)
            ->where('offers.status', 'accepted')
            ->get();

         return view('user.reviews.index', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->pageTitle = trans('menu.postListing');
        $this->categories = Category::all();
        return view('user/listing/create', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modelView($id, $type)
    {
        $this->listing = Listing::with('user', 'offer', 'offer.user')->findOrFail($id);
        $this->toUserName = $this->listing->user->name;

        if($type == 'freelance'){
            $this->offer = $this->listing->offer->filter(function ($value, $key) {
                return $value->status == 'accepted' && $value->id == $this->user->id;
            })->first();

            $this->toUserName = $this->offer->user->name;
        }

        $this->freelancer = $this->user->name;

        $this->type = $type;

        $view =  view('user/reviews/post-review', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function store(CreateRequest $request)
    {
        $rating = 0;
        if($request->rating == '5'){
            $rating = 1;
        }
        elseif($request->rating == '4'){
            $rating = 2;
        }
        elseif($request->rating == '3'){
            $rating = 3;
        }
        elseif($request->rating == '2'){
            $rating = 4;
        }elseif($request->rating == '1'){
            $rating = 5;
        }

        $list = Listing::acceptedOffer($request->listID);

        //Listing Details store
        $listing = new Feedback();
        $listing->rating       = $rating;
        $listing->description  = $request->textarea;
        $listing->listing_id   = $request->listID;
        $listing->type_as      = $request->type;
        $listing->user_id      = $this->user->id;
        $listing->people_id    = $list->user_id;
        $listing->save();

        if($request->type == 'client'){
            $this->listing = Listing::with(['freelance_client','freelance_client.user',])->findOrFail($request->listID);
        }
        else{
            $this->listing = Listing::with(['freelance_feedback','freelance_feedback.user',])->findOrFail($request->listID);
        }

        $this->type = $request->type;

        $view = view('user/reviews/list-review', $this->data)->render();

        return Reply::success(__('messages.reviewPosted'), ['view' => $view, 'type' => $request->type, 'list_id' => $this->listing->id]);
    }

}
