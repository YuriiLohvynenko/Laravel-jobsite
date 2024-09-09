<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Specialities;
use App\Models\UserSpecialities;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DashBoardReviewsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->pageTitle = trans('menu.dashboardReview');
        $reviews = Listing::with('user')->selectRaw(
            'listings.id, listings.order_no, 
            ( select description from feedbacks where feedbacks.listing_id = listings.id and feedbacks.type_as = \'client\' and feedbacks.deleted_at IS NULL ) as client_feedback,
            ( select user_id from feedbacks where feedbacks.listing_id = listings.id and feedbacks.type_as = \'client\' and feedbacks.deleted_at IS NULL) as client_id,
            ( select description from feedbacks where feedbacks.listing_id = listings.id and feedbacks.type_as = \'freelancer\' and feedbacks.deleted_at IS NULL ) as freelancer_feedback,
            ( select user_id from feedbacks where feedbacks.listing_id = listings.id and feedbacks.type_as = \'freelancer\' and feedbacks.deleted_at IS NULL) as freelancer_id
            ')
            ->join('feedbacks', 'feedbacks.listing_id', 'listings.id')
            ->distinct()
            ->get();
//        dd($reviews);
        $allreviews = [];
        foreach ($reviews as $key => $review){
            $client = User::where('id', $review->client_id)->first();
            $freelancer = User::where('id', $review->freelancer_id)->first();
            $allreviews[$key]['id'] = $review->id;
            $allreviews[$key]['order_no'] = $review->order_no;
            $allreviews[$key]['client_feedback'] = $review->client_feedback;
            $allreviews[$key]['client_id'] = $review->client_id;
            $allreviews[$key]['client_name'] = $client != null ? $client->first_name.' '.$client->last_name : '';
            $allreviews[$key]['freelancer_feedback'] = $review->freelancer_feedback;
            $allreviews[$key]['freelancer_id'] = $review->freelancer_id;
            $allreviews[$key]['freelancer_name'] = $freelancer != null ? $freelancer->first_name.' '.$freelancer->last_name : '';
        }


        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($allreviews);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());

        $this->reviews = $paginatedItems;

        return view('admin/reviews/dashboard-reviews', $this->data);
    }

    public function show($id){

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(ProfileUpdateRequest $request,  $id)
    {

    }

    public function contactUser($client_id, $freelancer_id){
        $this->client = $client_id;
        $this->freelancer = $freelancer_id;
        $view = view('admin/reviews/messages-popup', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function sendMessage(Request $request, $id){
        $adminUser = User::where('username', 'admin')->first();
        $message = new Message();
        $message->user_id       = $adminUser->id;
        $message->to_user       = $id;
        $message->message       = $request->message;
        $message->save();
        return Reply::success('Message Send successfully.');
    }

    public function deleteFeedback($listingId){
        $this->listingId = $listingId;
        $view = view('admin/reviews/delete-feedback', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function deleteReview($listingId, $type){
        $review = Feedback::where('listing_id', $listingId)->where('type_as', $type)->first();
        Feedback::destroy($review->id);
        return Reply::success('Feedback Deleted successfully');
    }
}
