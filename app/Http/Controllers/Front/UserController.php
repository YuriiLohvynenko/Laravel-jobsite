<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Front\Invite\CreateRequest;
use App\Models\Bookmark;
use App\Models\Feedback;
use App\Models\Invite;
use App\Notifications\NewJobInvitation;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Offer;
use App\User;
use Carbon\Carbon;
use Share;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if(auth()->guard('job-seeker')->check()) {
            $this->user = auth()->guard('job-seeker')->user();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->title = 'Home';
        return view('front/listing/view-listing', $this->data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->title = 'Profile';
        $this->profile = User::with(['detail','specialties','feedbacks','listings','specialties.specialty', 'badge'])->findOrFail($id);
        $this->previousTitles = ($this->profile->detail && $this->profile->detail->previous_job_titles != null) ? \GuzzleHttp\json_decode($this->profile->detail->previous_job_titles) : [] ;
        $this->checkBookmark = $this->profile->checkBookmark();
        $feedbacks = Feedback::with(['user','listing','people'])->where('user_id', $id)->get();

        $this->freelanceFeedbacks = $feedbacks->filter(function ($value, $key) {
            return $value->type_as == 'freelancer';
        });

        $this->clientFeedbacks = $feedbacks->filter(function ($value, $key) {
            return $value->type_as == 'client';
        });

        /* “Reliability.” Shows “Job Success” by “Rating” */
        $sumOfRating = 0;
        $totalRating = 0;
        $this->percentRating = 0;

        if ($this->profile->feedbacks){
            $totalRating = $this->profile->feedbacks->count()*5;
            foreach ($this->profile->feedbacks as $feedback){
                $sumOfRating += $feedback->rating;
            }
        }

        if ($totalRating > 0 && $sumOfRating > 0){
            $this->percentRating = $sumOfRating/$totalRating*100;
        }

        /* Job Success.” Shows the percentage cancelled by the percentage not cancelled */

        $this->jobSuccess = 0;
        $cancelled = Offer::where('user_id', $id)->where('status', 'rejected')->count();

        $completedOffers = Offer::where('offers.user_id', $id)
            ->where('offers.status', 'accepted')
            ->join('listings', 'listings.id', 'offers.listing_id')
            ->where('listings.status', 'completed')
            ->count();

        if ($cancelled > 0 && $completedOffers > 0){
            $this->jobSuccess = $completedOffers/$cancelled*100;
        }

        $this->share = Share::page(route('user.profile.show', $id), $this->profile->first_name .' '. $this->profile->last_name)
            ->facebook($this->user ? $this->user->detail->introduction: '')
            ->twitter($this->user ? $this->user->detail->introduction: '')
            ->linkedin($this->user ? $this->user->detail->introduction: '');

        return view('front/user/profile', $this->data)->with('intro', json_decode($this->profile->detail, true));
    }

    /**
     * @param $userId
     * @return array
     */
    public function changeBookmark($userId){
        $bookmark = Bookmark::where('people_id', $userId)->where('user_id', $this->user->id)->first();

        if($bookmark){
            $bookmark->delete();
            return Reply::success('Bookmark removed successfully');
        }
        else{
            $mark = new Bookmark();
            $mark->people_id = $userId;
            $mark->user_id = $this->user->id;
            $mark->save();

            return Reply::success('Bookmarked successfully');
        }
    }

    /**
     * @param CreateRequest $request
     * @return array
     */
    public function invite(CreateRequest $request){

        $user = auth()->guard('job-seeker')->user();

        if(count($request->job) > 0){
            foreach ($request->job as $job) {
                $invite = new Invite();
                $invite->user_id = $user->id;
                $invite->people_id = $request->userID;
                $invite->listing_id = $job;
                $invite->save();

                $listing = Listing::findOrFail($job);
//        dd(route('user.profile.show', $this->user->id));

                $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Invitation Received <a href="'.route('user.profile.show', $user->id).'">'.$user->first_name .' '.$user->last_name.'</a><span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                            </p>';
//        dd($this->message);
                $message = new Message();
                $message->user_id       = $user->id;
                $message->to_user       = $request->userID;
                $message->listing_id    = $listing->id;
                $message->message       = $this->message;
                $message->save();
            }
        }

        $freelancer = User::find($request->userID);
        if ($freelancer) {
            $freelancer->notify(new NewJobInvitation($invite));
        }

        return Reply::success('Invite sent successfully');
    }
}
