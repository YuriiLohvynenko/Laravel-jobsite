<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Models\Listing;
use App\Models\Offer;
use App\Models\Bookmark;
use App\Models\Dispute;
use App\Models\Feedback;
use App\Models\ListingBudget;
use Carbon\Carbon;

class DashBoardController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'Dashboard';
        $this->postedListings = Listing::with([
                'budgetDetails' => function ($q) {
                    $q->orderBy('date_time')->with('shift');
                },
                'offer' => function ($q) {
                    $q->where('status', 'accepted')->with('user');
                }
            ])->whereMonth('date_time', '=', Carbon::now()->month)
			->whereYear('date_time', '=', Carbon::now()->year)
            ->where('user_id', $this->user->id)
        // ->where('status', 'accepted')
        ->get();
		
		$currweek = date('W');
		$paidquery = Listing::select('id')->with('bookmark')->where('user_id',$this->user->id)->get();
		$this->bookmark = 0;
		$this->dispute = 0;
		$this->feedback = 0;
		$this->totalpaid = 0;
		$this->weeklypaid = 0;
		$this->assigned = 0;
		$this->assignedcancelled = 0;
		$this->earned = 0;
		$this->earnedcancelled = 0;
		$disputesquery = Dispute::select('id')->where('user_id',$this->user->id)->get();
		$bookmarkquery = Bookmark::select('id')->where('people_id',$this->user->id)->get();
		$feedbackquery = Feedback::select('id')->where('user_id',$this->user->id)->get();
		$offerqueryacc = Offer::select('id')->where('user_id',$this->user->id)->where('status','accepted')->get();
		if($offerqueryacc){
			$this->earned += count($offerqueryacc);
		}
		$offerquerycan = Offer::select('id')->where('user_id',$this->user->id)->where('status','rejected')->get();
		if($offerquerycan){
			$this->earnedcancelled += count($offerquerycan);
		}
		if($disputesquery){
			$this->dispute += count($disputesquery);
		}
		if($bookmarkquery){
			$this->bookmark += count($bookmarkquery);
		}
		if($feedbackquery){
			$this->feedback += count($feedbackquery);
		}
		foreach($paidquery as $pay){
			$disputes = Dispute::select('id')->where('status','pending')->where('listing_id',$pay->id)->get();
			if($disputes){
				$this->dispute += count($disputes);
			}
			$feedback = Feedback::select('id')->where('listing_id',$pay->id)->get();
			if($feedback){
				$this->feedback += count($feedback);
			}
			$offer = Offer::select('amount','created_at','status')->where('listing_id',$pay->id)->where('status','accepted')->first();
			if($offer){
				$this->assigned += 1;
				$this->totalpaid += $offer->amount;
				if($currweek == date('W', strtotime($offer->created_at))){
					$this->weeklypaid += $offer->amount;
				}
			}
			
			$canceloffer = Offer::select('amount','created_at','status')->where('listing_id',$pay->id)->where('status','rejected')->get();
			if($canceloffer){
				$this->assignedcancelled += count($canceloffer);
			}
		}
		
        $this->myOffers = $this->user->acceptedOffers()->where('user_id', $this->user->id)
        ->get();
		$this->totalearned = 0;
		$this->weeklyearned = 0;
        $myListingsArr = [];
        foreach ($this->myOffers as $offer) {
			$this->totalearned += $offer->amount;
			if($currweek == date('W', strtotime($offer->created_at))){
				$this->weeklyearned += $offer->amount;
			}
            // $listing = $offer->listing()->with(
                // [
                    // 'budgetDetails' => function ($query) {
                        // $query->orderBy('date_time')->with('shift');
                    // }, 'offer' => function ($q) {
                        // $q->where('status', 'accepted')->with('user');
                    // }
                // ]
            // )
            // ->whereMonth('created_at', request()->month+1)
            // ->whereYear('created_at', request()->year)
            // ->first();
			$listing = Listing::with([
				'budgetDetails' => function ($q) {
					$q->orderBy('date_time')->with('shift');
				},
				'offer' => function ($q) {
					$q->where('status', 'accepted')->with('user');
				}
			])
			->where('id', $offer->listing_id)
			->first();
            if ($listing) {
                array_push($myListingsArr, $listing);
            }
        }
        $this->myListings = collect(array_values($myListingsArr));

        return view('user/dashboard/dashboard', $this->data);
    }

    public function listingsByMonth()
    {
        $this->postedListings = Listing::with([
            'budgetDetails' => function ($q) {
                $q->orderBy('date_time')->with('shift');
            },
            'offer' => function ($q) {
                $q->where('status', 'accepted')->with('user');
            }
        ])
        ->whereMonth('date_time', '=', request()->month+1)
        ->whereYear('date_time', '=', request()->year)
        ->where('user_id', $this->user->id)
        // ->where('status', 'accepted')
        ->get();

        $this->myOffers = $this->user->acceptedOffers()->where('user_id', $this->user->id)
        ->get();
        $myListingsArr = [];
        foreach ($this->myOffers as $offer) {
            // $listing = $offer->listing()->with(
                // [
                    // 'budgetDetails' => function ($query) {
                        // $query->orderBy('date_time')->with('shift');
                    // }, 'offer' => function ($q) {
                        // $q->where('status', 'accepted')->with('user');
                    // }
                // ]
            // )
            // ->whereMonth('created_at', request()->month+1)
            // ->whereYear('created_at', request()->year)
            // ->first();
			$listing = Listing::with([
				'budgetDetails' => function ($q) {
					$q->orderBy('date_time')->with('shift');
				},
				'offer' => function ($q) {
					$q->where('status', 'accepted')->with('user');
				}
			])
			->where('id', $offer->listing_id)
			->first();
            if ($listing) {
                array_push($myListingsArr, $listing);
            }
        }
        $this->myListings = collect(array_values($myListingsArr));

        return Reply::dataOnly(['postedListings' => $this->postedListings, 'myListings' => $this->myListings]);
    }
}
