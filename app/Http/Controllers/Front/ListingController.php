<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Front\Offer\CreateRequest;
use App\Http\Requests\Front\RegisterRequest;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Offer;
use App\Models\UserDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewBidCreated;
use Share;

class ListingController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if(auth()->guard('job-seeker')->check()) {
            $this->user = auth()->guard('job-seeker')->user();
        }

    }

    public function index()
    {
        $this->title = 'Home';
        return view('front/listing/view-listing', $this->data);
    }

    public function create(Request $request, $catID = null, $key = null)
    {
        $this->catID = [];
        if($catID) {
            $this->catID = explode('&', $catID);
            $this->catID = Category::whereIn('slug', $this->catID)->pluck('id')->toArray('id');
        }

        $this->pageTitle = trans('menu.postListing');
        $this->key = $key;
        $this->categories = Category::all();
        return view('front/listing/create', $this->data);
    }

    public function show($id)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offer' => function($q) {
            $q->with('user')->whereRaw('id = ( SELECT MAX(id) FROM offers as t WHERE t.user_id = offers.user_id AND t.listing_id = offers.listing_id)');
        }])->findOrFail($id);
        $this->title = 'Listing View | '.$this->listing->job_title;
        $this->totalBudget = 0;
        if($this->listing->budgetDetails){
            $this->totalBudget = $this->listing->budgetDetails->sum('budget');
        }

        $images = [];
        $attachments = [];
        if($this->listing->files){
            foreach($this->listing->files as $files){
                if($files->file_format == 'pdf' || $files->file_format == 'doc' || $files->file_format == 'docx' ){
                    $attachments[] =  $files;
                }
                else{
                    $images[] =  $files;
                }
            }
        }
        $this->images = $images;
        $this->attachments = $attachments;

        $this->checkBookmark = $this->listing->checkBookmark();
        $this->share = Share::page(route('listing.list.show', $id), $this->listing->job_title)
            ->facebook($this->listing->description)
            ->twitter($this->listing->introduction)
            ->linkedin($this->listing->introduction);
        return view('front/listing/view-listing', $this->data);
    }

    public function changeBookmark($listingId){
        $bookmark = Bookmark::where('listing_id', $listingId)->where('user_id', $this->user->id)->first();

        if($bookmark){
            $bookmark->delete();

            return Reply::success('Bookmark removed successfully', ['action' => 'remove']);
        }
        else{
            $mark = new Bookmark();
            $mark->listing_id = $listingId;
            $mark->user_id = $this->user->id;
            $mark->save();

            return Reply::success('Bookmarked successfully', ['action' => 'add']);
        }
    }

    public function storeOffer(CreateRequest $request)
    {
        $offer = new Offer();
        $offer->listing_id  = $request->listingID;
        $offer->user_id     = $this->user->id;
        $offer->amount      = $request->amount;
        $offer->description = $request->description;
        $offer->rating      = 0;
        $offer->save();
        $this->saveMessage($request, $offer);

        $offer->listing->user->notify(new NewBidCreated($offer));

        $htmlData = '<li>
                        <div class="bid">
                            <!-- Avatar -->
                            <div class="bids-avatar">
                                <div class="freelancer-avatar">
                                    <div class="verified-badge"></div>
                                    <a href="'.route('user.profile.show', $this->user->id).'"><img src="'.$this->user->image().'" alt="" /></a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="bids-content">
                                <!-- Name -->
                                <div class="freelancer-name">
                                    <h4><a href="'.route('user.profile.show', $this->user->id).'">'.ucfirst($this->user->full_name) .'</a></h4>
                                    <div class="star-rating" data-rating="'.$offer->rating.'"></div>
                                </div>
                                <div class="margin-top-10">'.$offer->description .'</div>
                            </div>

                            <!-- Bid -->
                            <div class="bids-bid">
                                <div class="bid-rate">
                                    <div class="rate">$'.$offer->amount.'</div>
                                </div>
                            </div>
                        </div>
                    </li>';

        return Reply::success('Bid placed successfully', ['postedData' => $htmlData]);
    }
    public function counterOffer(CreateRequest $request)
    {
        $offer = new Offer();
        $offer->listing_id  = $request->listingID;
        $offer->user_id     = $this->user->id;
        $offer->amount      = $request->amount;
        $offer->rating      = 0;
        $offer->save();
        $this->counterMessage($request, $offer);

        return Reply::success('Counter Offer Send successfully');
    }
    public function saveMessage($request, $offer)
    {
        $listing = Listing::findOrFail($request->listingID);

        $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Offer From <a href="'.route('user.profile.show', $this->user->id).'">'.$this->user->first_name .' '.$this->user->last_name.'</a><span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                                <div class="col-12 message-cancellation"><strong>Description:</strong> '. $request->description .'</div>
                                <div class="col-12 margin-top-20">
                                    <a href="javascript:;" id="feedback-left" data-offer-id="'. $offer->id .'" data-list-id="'. $request->listingID .'" class="button button-sliding-icon ripple-effect modal-default-button accept-offer">Accept Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
                                    <a href="javascript:;" id="feedback-left" data-offer-id="'. $offer->id .'" data-list-id="'. $request->listingID .'" class="button dark ripple-effect modal-default-button decline-offer">Decline Offer</a>
                                </div>
                            </p>';
//        dd($this->message);
        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $listing->user_id;
        $message->listing_id    = $request->listingID;
        $message->message       = $this->message;
        $message->save();
    }
    public function counterMessage($request, $offer)
    {
        $listing = Listing::findOrFail($request->listingID);

        $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Counter Offer <a href="'.route('user.profile.show', $this->user->id).'">'.$this->user->first_name .' '.$this->user->last_name.'</a><span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                                <div class="col-12 message-cancellation"><strong>Description:</strong> '. $request->description .'</div>
                                <div class="col-12 margin-top-20">
                                    <a href="javascript:;" id="feedback-left" data-offer-id="'. $offer->id .'" data-list-id="'. $request->listingID .'" class="button button-sliding-icon ripple-effect modal-default-button accept-offer">Accept Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
                                    <a href="javascript:;" id="feedback-left" data-offer-id="'. $offer->id .'" data-list-id="'. $request->listingID .'" class="button dark ripple-effect modal-default-button decline-offer">Decline Offer</a>
                                </div>
                            </p>';
        $oldOffer = Offer::find($request->offerID);
        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $oldOffer->user_id;
        $message->listing_id    = $request->listingID;
        $message->message       = $this->message;
        $message->save();
    }
    public function ajaxLogin(LoginRequest $request)
    {
        $username = $request->get('email');
        $password   = $request->get('password');

        // Credentials to check user login
        $credentials = ['email' => $username, 'password' => $password];
        $remember    = $request->remember ? true : false;

        if (auth()->guard('job-seeker')->attempt($credentials, $remember)) {
            // User login success
            // return Reply::success( 'messages.loginSuccess');
			return Reply::dataOnly(['status'=>'success']);
        }

        // Login Failed
        // return Reply::error('messages.loginFail');
		return Reply::dataOnly(['status'=>'success']);

//        return Reply::error('messages.accountDisableMessage');
    }
    /**
     * @param RegisterRequest $request
     * @return array
     */
    public function register(RegisterRequest $request)
    {
        \DB::beginTransaction();

        $userRegister                = new User();
        $userRegister->first_name    = $request->first_name;
        $userRegister->last_name     = $request->last_name;
        $userRegister->username      = $request->username;
        $userRegister->email         = rawurlencode(urlencode(base64_encode($request->email)));
        $userRegister->password      = bcrypt($request->password);

        $userRegister->save();
        $detail              = new UserDetail();
        $detail->user_id = $userRegister->id;
        $detail->save();

        \DB::commit();

        $credentials = ['email' => $userRegister->email, 'password' => $request->password];
        $remember    = true;

        if (auth()->guard('job-seeker')->attempt($credentials, $remember)) {
            // User login success
            return Reply::success('messages.signUpSuccess');
        }

        return Reply::error('error in register. please contact with administrator.');
    }
}
