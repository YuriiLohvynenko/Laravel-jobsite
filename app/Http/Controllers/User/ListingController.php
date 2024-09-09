<?php
namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Listing\CreateRequest;
use App\Http\Requests\Listing\DisputeCommentRequest;
use App\Http\Requests\Listing\DisputeCreateRequest;
use App\Http\Requests\Listing\IncreaseBudgetRequest;
use App\Http\Requests\Listing\OfferUpdateRequest;
use App\Models\BudgetIncreaseHistory;
use App\Models\Category;
use App\Models\Dispute;
use App\Models\DisputeChat;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\ListingBudget;
use App\Models\ListingFile;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail, File, Response;
class ListingController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.listing');

        $this->listings = Listing::selectRaw('listings.*,(CASE when immediate_assistance = "required" and datediff(NOW(), created_at) > 1 then "Hide" else "Show" End) as Isshow')->with(['user', 'files', 'dispute', 'budgetDetails' => function($q) {
                $q->with('shift');
            }, 'bookmark',
            'offer' => function($q) {
                $q->with('user')->where('user_id', '!=', $this->user->id)->where('status', '<>', 'rejected')->whereRaw('id = ( SELECT MAX(id) FROM offers as t WHERE t.user_id = offers.user_id AND t.listing_id = offers.listing_id)');
            }])
            ->where('user_id', $this->user->id)
            ->where('date_time', '>', Carbon::now())
            ->distinct()
            ->where('status', '<>', 'accepted')
            ->get();

        $this->activeListings = $this->listings->filter(function ($value, $key) {
            $milestones = $value->budgetDetails()->where('date_time', '>=', Carbon::now())->get();

            if ($milestones->count() > 0) {
                return true;
            }
            return false;
        });
		
        $this->assignedListings = Listing::select(['listings.*', 'offers.user_id as offer_user_id'])
            ->with(['user', 'files', 'budgetDetails', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }])
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->join('offers', 'offers.listing_id', 'listings.id')
            ->join('users', 'users.id', 'listings.user_id')
            ->where('listings.user_id', $this->user->id)
            ->where('offers.status', 'accepted')
            ->where('listing_budget_date.status','<>', 'completed')
			->whereRaw("offers.listing_id not in (SELECT listing_id FROM disputes)")
            ->where('listing_budget_date.date_time', '>=', Carbon::now())
            ->distinct()
            ->get();
			
        $this->clientdisputelist = Listing::select(['listings.id','listings.user_id','listings.job_title','listings.city','listings.state','listings.job_location'])
            ->with(['user', 'budgetDetails', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }])
			->join('disputes', 'disputes.listing_id', 'listings.id')
			->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('disputes.user_id', $this->user->id)
			->where('listing_budget_date.status', '<>','completed')
			->where('disputes.status', 'pending')
			->orwhere('disputes.status', 'accepted')
			->orwhere('disputes.status', 'rejected')
            ->distinct()
            ->get();
			
			$this->freelancerdisputelist = Listing::select(['listings.id','listings.user_id','listings.job_title','listings.city','listings.state','listings.job_location'])
            ->with(['user', 'budgetDetails', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }])
			->join('offers', 'offers.listing_id', 'listings.id')
			->join('disputes', 'disputes.listing_id', 'listings.id')
			->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('offers.user_id', $this->user->id)
			->where('listing_budget_date.status', '<>','completed')
			->where( function ( $query )
				{
					$query->where('disputes.status', 'pending')
						->orwhere('disputes.status', 'accepted')
						->orwhere('disputes.status', 'rejected');
				})
			
            ->distinct()
            ->get();
			
			 $this->clientendedListings = Listing::select(['listings.id','listings.user_id','listings.job_title','listings.city','listings.state','listings.job_location'])
            ->with(['user', 'budgetDetails', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }])
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('listings.user_id', $this->user->id)
            ->whereDate('listing_budget_date.date_time', '<', Carbon::now())
            ->distinct()
            ->get();
			
			$this->freelancerendedListings = Listing::select(['listings.id','listings.user_id','listings.job_title','listings.city','listings.state','listings.job_location'])
			->with(['user', 'budgetDetails', 'bookmark',
			'offer' => function($q) {
				$q->with('user');
			}])
			->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
			->join('offers', 'offers.listing_id', 'listings.id')
			->where('offers.user_id', $this->user->id)
			->where( function ( $query )
				{
					$query->where('offers.status', 'accepted')
						  ->where('offers.status', 'pending');
				})
            
            ->whereDate('listing_budget_date.date_time', '<', Carbon::now())
            ->distinct()
            ->get();

        $this->freelancerActive = Listing::select(['listings.*'])
            ->with(['user', 'files', 'dispute', 'budgetDetails'  => function($q) {
                $q->with('shift');
            }, 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            },'selected_offer'])
            ->join('offers', 'offers.listing_id', 'listings.id')
            ->join('users', 'users.id', 'listings.user_id')
			->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('offers.user_id', $this->user->id)
            ->where('offers.status', 'pending')
			->where('listing_budget_date.status', 'pending')
            ->distinct()
            ->get();
			
			$this->freelancerAssigned = Listing::select(['listings.*'])
            ->with(['user', 'files', 'dispute', 'budgetDetails'  => function($q) {
                $q->with('shift');
            }, 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            },'selected_offer'])
            ->join('offers', 'offers.listing_id', 'listings.id')
            ->join('users', 'users.id', 'listings.user_id')
			->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->where('offers.user_id', $this->user->id)
			->whereRaw("offers.listing_id not in (SELECT listing_id FROM disputes)")
            ->where('offers.status', 'accepted')
			->where('listing_budget_date.status', 'pending')
            ->distinct()
            ->get();
			
			 $this->clientcompleted = Listing::select(['listings.*'])
					->with(['user', 'files', 'dispute', 'budgetDetails'  => function($q) {
					$q->with('shift');
					}, 'bookmark',
					'offer' => function($q) {
					$q->with('user');
					},'selected_offer'])
					->join('offers', 'offers.listing_id', 'listings.id')
					->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
					->join('users', 'users.id', 'listings.user_id')
					->where('listings.user_id', $this->user->id)
					->where('listing_budget_date.status', 'completed')
					->orwhere('listing_budget_date.status', 'wait')
					->distinct()
					->get();
			
			$completed = Listing::select(['listings.*'])
					->with(['user', 'files', 'dispute', 'budgetDetails'  => function($q) {
					$q->with('shift');
					}, 'bookmark',
					'offer' => function($q) {
					$q->with('user');
					},'selected_offer'])
					->join('offers', 'offers.listing_id', 'listings.id')
					->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
					->join('users', 'users.id', 'listings.user_id')
					->where('offers.user_id', $this->user->id)
					->where('listing_budget_date.status', 'completed')
					->orwhere('listing_budget_date.status', 'wait')
					->distinct()
					->get();
					$myListingsArr = [];
		foreach($completed as $complete){
				
			$budget = ListingBudget::where('status', 'pending')->where('listing_id',$complete->id)->distinct()->get();
			
			if(count($budget)==0){
				array_push($myListingsArr, $complete);
					
			}
		}
		$this->completed = collect(array_values($myListingsArr)); 
		
        $this->ended = Listing::select(['listings.*'])
            ->with(['user', 'files', 'dispute', 'budgetDetails'  => function($q) {
                $q->with('shift');
            }, 'category', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            },'selected_offer'])
            ->join('listing_budget_date', 'listing_budget_date.listing_id', 'listings.id')
            ->join('users', 'users.id', 'listings.user_id')
            ->where('listings.user_id', $this->user->id)
            ->where('listing_budget_date.status', 'pending')
            ->distinct()
            ->get();

        $this->offers = Offer::with(['user', 'listing'])
            ->where('user_id', $this->user->id)->get();
			
        return view('user.listing.index', $this->data);
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

    public function store(CreateRequest $request)
    {
        $budgets = $request->budgetValue;
        $total = 0;
        foreach($budgets as $budget) {
            $total += floatval(preg_replace('/[^\d.]/', '', $budget));
        }
		// print_r($request); die();
        //Listing Details store
        $listing = new Listing();
        $listing->category_id    = $request->category;
        $listing->job_title      = $request->title;
        $listing->description    = $request->description;
        $listing->materials      = $request->materials;
        $listing->date_time      = Carbon::parse(max($request->budgetDate))->format('Y-m-d H:i:s');
        $listing->budget         = $total;
        $listing->job_location   = $request->job_location;
		$listing->immediate_assistance   = $request->immediate_assistance;
        $listing->address        = $request->address;
        $listing->street_address = $request->street_address;
        $listing->city           = $request->city;
        $listing->state          = $request->state;
        $listing->zip_code       = $request->zip;
        $listing->user_id        = $this->user->id;
        $listing->latitude       = $request->lat;
        $listing->longitude      = $request->long;

        $listing->save();
		$listingid = base64_encode($listing->id);
        // Budget detail save
        if(count($request->budgetDate) > 0){
            foreach($request->budgetDate as $index => $budgetDate){
                $budget = $request->budgetValue;
                if($budgetDate != 0 && $budgetDate != '' && $budgetDate != null && $budget[$index] != 0 && $budget[$index] != '' && $budget[$index] != null)
                {
                    $budgetDetail = new ListingBudget();
                    $budgetDetail->date_time = Carbon::parse($budgetDate)->format('Y-m-d H:i:s');
                    $budgetDetail->budget = floatval(preg_replace('/[^\d.]/', '', $budget[$index]));
                    $budgetDetail->listing_id = $listing->id;
                    $budgetDetail->save();
                }

            }
        }
		
		// if(count($request->file) > 0){
            // foreach ($request->file as $index => $value) {
                // if ($value != '' && $value != null) {
// // print_r($value);
                    // $fileName = $value->hashname();
                    // $ds = explode('.', $fileName);
                    // $value->store('public/listing-files');
                    // $dsCount = count($ds);
                    // $file = new ListingFile();
                    // $file->listing_id = $request->listingID;
                    // $file->file_name = $ds[0];
                    // $file->file_format = $ds[$dsCount-1];
                    // $file->save();
                // }
            // }
        // }
			// print_r($listingid);
			// die();
        // return Reply::redirect(route('user.listing.index',$listingid), __('messages.listingCreated'));
		// return Reply::success('Job Created Successfully');
		// print_r($listing->id);
		// die();
		return Reply::dataOnly(['status'=>'success', 'listingid' => $listing->id]);
    }

    public function uploadFiles(Request $request)
    {
		
		 // $file = File::get(storage_path('app/public/listing-files/uHojVnWNG4NAUZ4Thb6PMQUCtZ97cn8H44VZgoxy.jpeg'));
    // $type = File::mimeType(storage_path('app/public/listing-files/uHojVnWNG4NAUZ4Thb6PMQUCtZ97cn8H44VZgoxy.jpeg'));

    // $response = Response::make($file, 200);
    // $response->header("Content-Type", $type);

    // return $response;
		// die();
        if(count($request->file) > 0){
            foreach ($request->file as $index => $value) {
                if ($value != '' && $value != null) {
// print_r($value);
                    $fileName = $value->hashname();
                    $ds = explode('.', $fileName);
                    $value->store('public/listing-files');
                    $dsCount = count($ds);
                    $file = new ListingFile();
                    $file->listing_id = $request->listingID;
                    $file->file_name = $ds[0];
                    $file->file_format = $ds[$dsCount-1];
                    $file->save();
                }
            }
        }

        return Reply::success('File Uploaded');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function viewOffer($id)
    {
        // $this->offerDetail = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
        // $q->with('user')->where('user_id', '!=', $this->user->id);
		
		$this->offerDetail = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
			// print_r($id);
        $q->with('user')->where('user_id', '!=', $this->user->id)->where('status', '<>', 'rejected')->whereRaw('id = ( SELECT MAX(id) FROM offers as t WHERE t.user_id = offers.user_id AND t.listing_id = offers.listing_id)')->groupBy("user_id");
        }])->where('id', $id)->first();
        $this->totalBudget = 0;
        if($this->offerDetail->budgetDetails){
            $this->totalBudget = $this->offerDetail->budgetDetails->sum('budget');
        }

        $view = view('user/listing/view-offer', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function repostListing(Request $request, $listingId){
        if ($request->ajax()){
            $this->listingId = $listingId;
            $view = view('user/listing/repost-listing', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        else{
            $this->pageTitle = trans('menu.postListing');
            $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
                'offer' => function($q) {
                    $q->with('user');
                }])->findOrFail($listingId);
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
            $this->categories = Category::all();
            return view('user/listing/store-repost', $this->data);
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function updateOffer($id)
    {
        $this->offer = Offer::where('listing_id', $id)->where('user_id', $this->user->id)->first();

        $view = view('user/listing/update-offer', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function counterOffer($id)
    {
        $this->offer = Offer::find($id);

        $view = view('user/listing/counter-offer', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function submitOffer(OfferUpdateRequest $request)
    {
        $offer = Offer::findOrFail($request->offer_id);
        $offer->amount = $request->amount;
        $offer->save();

        return Reply::success('Offer updated successfully');
    }

    /**
     * @param $listing_id
     * @param $user_id
     * @return mixed
     * @throws \Throwable
     */
    public function offerDetail($listing_id, $user_id)
    {
        $this->offer = Offer::with(['user', 'listing'])->where('listing_id', $listing_id)->where('user_id', $user_id)->orderby('id','DESC')->first();

        $view = view('user/listing/offer-detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function openDispute($listing_id)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with(['user'])->where('status', 'accepted');;
        }])->where('id', $listing_id)->first();
        $this->freelancer = $this->listing->offer->first();
//        dd($this->freelancer);

        $view = view('user/listing/create-dispute', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function openBidDispute($listing_id)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with(['user'])->where('status', 'accepted');;
        }])->where('id', $listing_id)->first();
        $this->freelancer = $this->listing->offer->first();

        $view = view('user/listing/create-bid-dispute', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function changeShift($listing_id, $type)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with(['user'])->where('status', 'accepted');
        }])->where('id', $listing_id)->first();
        $this->freelancer = $this->listing->offer->first();

        $this->type = $type;
        $view = view('user/listing/change-shift', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function submitShift(Request $request)
    {
        $this->listing = Listing::with(['user', 'files', 'dispute', 'budgetDetails', 'category', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }])->where('id', $request->listingID)->first();

        if($request->type == 'start')
        {
            $list = $this->listing->budgetDetails->filter(function ($value, $key) {
                return $value->date_time > Carbon::now();
            })->first();
//            dd($list->shift);
            if ($list->shift == null){
                $shift = new Shift();
                $shift->listing_id = $request->listingID;
                $shift->budget_id = $list->id;
                $shift->user_id = $this->user->id;
                $shift->start_date = Carbon::now()->format('Y-m-d H:i:s');
                $shift->save();
                $btn = '<a href="javascript:;" onclick="changeShift('.$this->listing->id .', \'end\')" class="popup-with-zoom-anim button dark ripple-effect">End Shift <i class="icon-feather-watch"></i></a>';
                return Reply::success('Successfully shift changed',  ['view' => $btn, 'type' => 'start']);
            }
            else{
                return Reply::error('You can\'t start shift now');
            }
        }
        if($request->type == 'end')
        {
            $clockOut = $this->listing->budgetDetails->filter(function ($value, $key) {
                return $value->shift != null &&  $value->shift->start_date != null &&  $value->shift->end_date == null;
            })->first();

            if ($clockOut->shift != null){
                $shift =  Shift::findOrFail($clockOut->shift->id);
                $shift->end_date = Carbon::now()->format('Y-m-d H:i:s');
                $shift->save();

                $budget = ListingBudget::findOrFail($clockOut->id);
                $budget->status = 'completed';
                return Reply::success('Successfully shift changed',  [ 'type' => 'end']);
            }
            else{
                return Reply::error('Shift not started yet');
            }
        }

        return Reply::success('Successfully shift changed.');
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function showDispute($listing_id)
    {
        $this->listing = Listing::with(['offer' => function($q) {
            $q->with(['user'])->where('status', 'accepted');;
        }])->where('id', $listing_id)->first();

        $this->dispute = Dispute::with(['chat' => function($q) {
                    $q->with(['user']);
        }])->where('listing_id', $this->listing->id)->first();

        $this->freelancer = $this->listing->offer->first();
        $this->timer = '00:00';
        $total_hours = 0;
        $total_minutes = 0;
        $currentTime = Carbon::now();
        if(!is_null($this->dispute->cancellation_time) && $this->dispute->cancellation_time > Carbon::now()->toDateString()){
            $total_hours = ($this->dispute->cancellation_time->diff($currentTime)->format('%d')*24)+($this->dispute->cancellation_time->diff($currentTime)->format('%H'));

                if($total_hours == 0){
                    $total_hours = round(($this->dispute->cancellation_time->diff($currentTime)->format('%i')/60),2);
                }
                $total_minutes = ($total_hours*60)+($this->dispute->cancellation_time->diff($currentTime)->format('%i'));
        }

        $timeLog = intdiv($total_minutes, 60).'h ';

        if(($total_minutes % 60) > 0){
            $timeLog.= ($total_minutes % 60).'m';
        }

        $this->timer = $timeLog;

        $view = view('user/listing/view-dispute', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function showBidDispute($listing_id)
    {
        $this->listing = Listing::with(['offer' => function($q) {
            $q->with(['user'])->where('status', 'accepted');;
        }])->where('id', $listing_id)->first();

        $this->dispute = Dispute::with(['chat' => function($q) {
                    $q->with(['user']);
        }])->where('listing_id', $this->listing->id)->first();

        $this->freelancer = $this->listing->offer->first();
        $total_hours = 0;
        $total_minutes = 0;
        $currentTime = Carbon::now();
        if(!is_null($this->dispute->cancellation_time) && $this->dispute->cancellation_time > Carbon::now()->toDateString()){
            $total_hours = ($this->dispute->cancellation_time->diff($currentTime)->format('%d')*24)+($this->dispute->cancellation_time->diff($currentTime)->format('%H'));

            if($total_hours == 0){
                $total_hours = round(($this->dispute->cancellation_time->diff($currentTime)->format('%i')/60),2);
            }
            $total_minutes = ($total_hours*60)+($this->dispute->cancellation_time->diff($currentTime)->format('%i'));
        }

        $timeLog = intdiv($total_minutes, 60).'h ';

        if(($total_minutes % 60) > 0){
            $timeLog.= ($total_minutes % 60).'m';
        }

        $this->timer = $timeLog;

        $view = view('user/listing/view-bid-dispute', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function storeDispute(DisputeCreateRequest $request)
    {
        $dispute = new Dispute();
        $dispute->user_id = $this->user->id;
        $dispute->listing_id = $request->listing_id;
        $dispute->reason = $request->reason;
        $dispute->description = $request->text;
        $dispute->cancellation_time = Carbon::now()->addHours(48);
        $dispute->save();
        $button = '<a href="javascript:;"  onclick="showDispute('.$request->listing_id.')" class="popup-with-zoom-anim button ripple-effect" title="Not Satisfied" data-tippy-placement="top"><i class="icon-feather-thumbs-down"></i></a>';

        $listing = Listing::find($request->listing_id);
        $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Cancellation Request <span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                                <div class="col-12 message-cancellation"><strong>Request Timer:</strong> 22h 28m <i class="icon-feather-info" title="If client is unresponsive in this time funds will be refunded" data-tippy-placement="top"></i></div>
								<div class="col-12 message-cancellation"><strong>Reason:</strong>'.$request->reason.'</div>
								<div class="col-12 message-cancellation margin-bottom-20"><strong>Reason:</strong> '.$request->text.'</div>
                                <div class="col-12 margin-top-20">
                                    <a href="javascript:;" id="feedback-left" onclick="acceptDispute('.$dispute->id.')" class="button button-sliding-icon ripple-effect modal-default-button accept-dispute">Approve Request <i class="icon-material-outline-arrow-right-alt"></i></a>
                                    <a href="javascript:;" id="feedback-left" onclick="declineDispute('.$dispute->id.')" class="button dark ripple-effect modal-default-button decline-dispute">Decline Request</a>
                                </div>
                            </p>';
//        dd($this->message);
        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $request->user_id;
        $message->listing_id    = $listing->id;
        $message->message       = $this->message;
        $message->save();

        return Reply::success('Dispute file successfully', ['view' => $button] );
    }

    public function storeBidDispute(DisputeCreateRequest $request)
    {
        $dispute = new Dispute();
        $dispute->user_id = $this->user->id;
        $dispute->listing_id = $request->listing_id;
        $dispute->reason = $request->reason;
        $dispute->description = $request->text;
        $dispute->cancellation_time = Carbon::now()->addHours(48);
        $dispute->save();
        $button = '<a href="javascript:;"  onclick="showDispute('.$request->listing_id.')" class="popup-with-zoom-anim button ripple-effect" title="Not Satisfied" data-tippy-placement="top"><i class="icon-feather-thumbs-down"></i></a>';

        return Reply::success('Dispute file successfully', ['view' => $button] );
    }

    public function storeComment(DisputeCommentRequest $request)
    {

        $disputeChat = new DisputeChat();
        $disputeChat->user_id = $this->user->id;
        $disputeChat->dispute_id = $request->dispute_id;
        $disputeChat->posted_by = 'client';
        $disputeChat->comment = $request->text;

        $fileName = [];
        if($request->image){
            foreach ($request->image as $index => $value) {
                if ($value != '' && $value != null) {
                    $fileName[] = $value->hashname();
                    $value->store('public/dispute-files');
                }
            }
        }
        $disputeChat->image = json_encode($fileName);

        $disputeChat->save();

        return Reply::success('Dispute file successfully');
    }

    public function storeBidComment(DisputeCommentRequest $request)
    {

        $disputeChat = new DisputeChat();
        $disputeChat->user_id = $this->user->id;
        $disputeChat->dispute_id = $request->dispute_id;
        $disputeChat->posted_by = 'freelancer';
        $disputeChat->comment = $request->text;

        $fileName = [];
        if($request->image){
            foreach ($request->image as $index => $value) {
                if ($value != '' && $value != null) {
                    $fileName[] = $value->hashname();
                    $value->store('public/dispute-files');
                }
            }
        }
        $disputeChat->image = json_encode($fileName);

        $disputeChat->save();

        return Reply::success('Dispute file successfully');
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function increaseBudget($listing_id)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }])->where('id', $listing_id)->first();
        $this->currentDate = Carbon::now()->toDateString();
        $view = view('user/listing/increase-offer', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function showReleasePayment($budget_id)
    {
        $this->budgetDetail = ListingBudget::findOrFail($budget_id);
        $this->budgetDetails = ListingBudget::where('listing_id', $this->budgetDetail->listing_id)->get();
        $this->total = 0;
        foreach ($this->budgetDetails as $budgetDetail){
            $this->total += $budgetDetail->budget;
        }
        $view = view('user/listing/release-payment', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }
    public function releasePayment($budget_id)
    {
        $this->budgetDetail = ListingBudget::findOrFail($budget_id);
        $this->budgetDetail->status = 'wait';
        $this->budgetDetail->save();
        return Reply::success('Payment Released Successfully');
    }

    /**
     * @param IncreaseBudgetRequest $request
     * @return array
     */
    public function UpdateBudget(IncreaseBudgetRequest $request)
    {
//        $budget = ListingBudget::findOrFail($request->date_of_increase);
//
//        $budgetAmount = ($budget->budget != null)? $budget->budget : 0;
//        $increase = ( $request->amount - $budgetAmount);
//        $budget->increased_budget = ($increase + $budget->increased_budget);
//        $budget->budget = $request->amount;
//        $budget->save();


        $budgetIncreaseHistory = new BudgetIncreaseHistory();
        $budgetIncreaseHistory->listing_budget_date_id = $request->date_of_increase;
        $budgetIncreaseHistory->amount = $request->amount;
        $budgetIncreaseHistory->reason = $request->reason;
        $budgetIncreaseHistory->save();

        return Reply::success('Increased successfully');
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function jobDetail($listing_id)
    {
        $this->jobDetail = Listing::with(['user', 'files', 'budgetDetails' => function($q) {
            $q->with('shift');
        }, 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }])->where('id', $listing_id)->first();
        $this->totalBudget = 0;

        if($this->jobDetail->budgetDetails){
            $this->totalBudget = $this->jobDetail->budgetDetails->sum('budget');
            $this->totalBudgetIncrease = $this->jobDetail->budgetDetails->sum('increased_budget');
        }

        $this->freelancerData = $this->jobDetail->offer->filter(function ($value, $key) {
             return $value->status == 'accepted';
        })->first();

        $this->upComingDate = ListingBudget::where('listing_id', $listing_id)->where('date_time', '>', Carbon::now()->toDateString())->orderBy('date_time', 'ASC')->first();
        $total_minutes = 0;
        $total_hours = 0;
        foreach($this->jobDetail->budgetDetails as $budgetDetails){

            if(!is_null($budgetDetails->shift)){
                $shift = $budgetDetails->shift;
                $total_hours += ($shift->end_date->diff($shift->start_date)->format('%d')*24)+($shift->end_date->diff($shift->start_date)->format('%H'));

                if($total_hours == 0){
                    $total_hours += round(($shift->end_date->diff($shift->start_date)->format('%i')/60),2);
                }
                $total_minutes += ($total_hours*60)+($shift->end_date->diff($shift->start_date)->format('%i'));
            }

        }

        $this->total_hours = $total_hours;
        $this->total_minutes = $total_minutes;


        $view = view('user/listing/job-detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function assignedJobDetail($listing_id)
    {
		// print_r($listing_id);
        $this->jobDetail = Listing::with(['user', 'files', 'budgetDetails' => function($q) {
            $q->with('shift', 'increase_history');
        }, 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }, 'budgetDetails.shift'])->where('id', $listing_id)->first();
        $this->showPaymentButton = 0;
        $this->releasePaymentShift = [];
        $this->releasePaymentTimer = '';
        foreach ($this->jobDetail->budgetDetails as $budgetDetail){
            if ($budgetDetail->shift){
                if ($budgetDetail->shift->end_date != null && $budgetDetail->status != 'completed'){
                    $this->showPaymentButton = 1;
                    $this->releasePaymentShift = $budgetDetail->shift;

                    $startTime = Carbon::parse($this->releasePaymentShift->end_date);
                    $finishTime = Carbon::now();
                    $fixTime = Carbon::parse($this->releasePaymentShift->end_date)->addHours('48');
                    $totalDuration = $fixTime->diffInSeconds($finishTime);
                    $this->releasePaymentTimer = gmdate('H:i', $totalDuration);
//                    dd($this->releasePaymentTimer);
                }
            }
        }
        $this->totalBudget = 0;

        if($this->jobDetail->budgetDetails){
            $total = 0;
            foreach($this->jobDetail->budgetDetails as $milestone) {
                if($milestone->increase_history->count() > 0)
                    $total += $milestone->increase_history->sum('amount');
            }
            $this->totalBudgetIncrease = $total;
            $this->totalBudget = $this->jobDetail->budgetDetails->sum('budget') + $total;

        }

        $this->freelancerData = $this->jobDetail->offer->filter(function ($value, $key) {
             return $value->status == 'accepted';
        })->first();

        $this->upComingDate = ListingBudget::where('listing_id', $listing_id)->where('date_time', '>', Carbon::now()->toDateString())->orderBy('date_time', 'ASC')->first();
        $total_minutes = 0;
        $total_hours = 0;
        foreach($this->jobDetail->budgetDetails as $budgetDetails){

            
                $shift = $budgetDetails->shift;
				//echo "<pre>";
				 //print_r($shift->start_date); die();
				if(!empty($shift->end_date)){
                $total_hours += ($shift->end_date->diff($shift->start_date)->format('%d')*24)+($shift->end_date->diff($shift->start_date)->format('%H'));

                if($total_hours == 0){
                    $total_hours += round(($shift->end_date->diff($shift->start_date)->format('%i')/60),2);
                }
                $total_minutes += ($total_hours*60)+($shift->end_date->diff($shift->start_date)->format('%i'));
            }

        }

        $this->total_hours = $total_hours;
        $this->total_minutes = $total_minutes;


        $view = view('user/listing/assigned-job-detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }
    /**
     * @param $listing_id
     * @return mixed
     */
    public function showBidJob($listing_id)
    {
        $this->jobDetail = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }])->where('id', $listing_id)->first();
        $this->totalBudget = 0;

        if($this->jobDetail->budgetDetails){
            $this->totalBudget = $this->jobDetail->budgetDetails->sum('budget');
            $this->totalBudgetIncrease = $this->jobDetail->budgetDetails->sum('increased_budget');
        }

        $this->upComingDate = ListingBudget::where('listing_id', $listing_id)->where('date_time', '>', Carbon::now()->toDateString())->orderBy('date_time', 'ASC')->first();

        $this->startDate = ListingBudget::where('listing_id', $listing_id)->orderBy('date_time', 'ASC')->first();

        $view = view('user/listing/bid-job-detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function showCompleteJob($listing_id)
    {
        $this->jobDetail = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }])->where('id', $listing_id)->first();
        $this->totalBudget = 0;

        if($this->jobDetail->budgetDetails){
            $this->totalBudget = $this->jobDetail->budgetDetails->sum('budget');
            $this->totalBudgetIncrease = $this->jobDetail->budgetDetails->sum('increased_budget');
        }

        $this->upComingDate = ListingBudget::where('listing_id', $listing_id)->where('date_time', '>', Carbon::now()->toDateString())->orderBy('date_time', 'ASC')->first();

        $this->completionDate = ListingBudget::where('listing_id', $listing_id)->orderBy('date_time', 'DESC')->first();
        $total_minutes = 0;
        $total_hours = 0;
        foreach($this->jobDetail->budgetDetails as $budgetDetails){

            if(!is_null($budgetDetails->shift)){
                $shift = $budgetDetails->shift;
                $total_hours += ($shift->end_date->diff($shift->start_date)->format('%d')*24)+($shift->end_date->diff($shift->start_date)->format('%H'));

                if($total_hours == 0){
                    $total_hours += round(($shift->end_date->diff($shift->start_date)->format('%i')/60),2);
                }
                $total_minutes += ($total_hours*60)+($shift->end_date->diff($shift->start_date)->format('%i'));
            }

        }

        $this->total_hours = $total_hours;
        $this->total_minutes = $total_minutes;
        $view = view('user/listing/complete-job-detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function showInvoice($listing_id)
    {
        $this->jobDetail = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark','offer' => function($q) {
            $q->with('user');
        }])->where('id', $listing_id)->first();
        $this->totalBudget = 0;

        if($this->jobDetail->budgetDetails){
            $this->totalBudget = $this->jobDetail->budgetDetails->sum('budget');
            $this->totalBudgetIncrease = $this->jobDetail->budgetDetails->sum('increased_budget');
        }

        $this->freelancerData = $this->jobDetail->offer->filter(function ($value, $key) {
            return $value->status == 'accepted';
        })->first();

        $this->upComingDate = ListingBudget::where('listing_id', $listing_id)->where('date_time', '>', Carbon::now()->toDateString())->orderBy('date_time', 'ASC')->first();

        $view = view('user/listing/show-invoice', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function showTip($listing_id)
    {
        $this->listing = Listing::findOrFail($listing_id);

        $view = view('user/listing/send-tip', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leaveReview($id)
    {
        $this->listing = Listing::with(['user', 'offer' => function($q) {
            $q->with('user');
        }])->findOrFail($id);

        $this->offer = $this->listing->offer->filter(function ($value, $key) {
            return $value->status == 'accepted';
        })->first();

        $this->freelancer = $this->offer->user->first_name.' '.$this->offer->user->last_name;

        $view =  view('user/listing/leave-review', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leaveCompleteReview($id)
    {
        $this->listing = Listing::with(['user', 'offer' => function($q) {
            $q->with('user');
        }])->findOrFail($id);

        $this->offer = $this->listing->offer->filter(function ($value, $key) {
            return $value->status == 'accepted';
        })->first();

        $this->freelancer = $this->offer->user->first_name.' '.$this->offer->user->last_name;

        $view =  view('user/listing/leave-complete-review', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function sendTip(Request $request){

    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function deleteListing($listing_id)
    {
        $this->listing = Listing::findOrFail($listing_id);

        $view = view('user/listing/delete-listing', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @param $listing_id
     * @return mixed
     */
    public function withdrawOffer($listing_id)
    {
        Offer::where('user_id', $this->user->id)->where('listing_id', $listing_id)->delete();

        return Reply::success('Offer withdraw successfully');
    }

    public function acceptOffer($id)
    {
        $offer = Offer::find($id);
        $offer->status = 'accepted';
        $offer->save();

        if ($offer->amount > $offer->listing->budget) {
            $reqMilestone = $offer->listing->budgetDetails()->orderBy('date_time', 'DESC')->first();
            $amountToAdd = $offer->amount - $offer->listing->budget;

            $reqMilestone->budget = round($reqMilestone->budget + $amountToAdd, 2);

            $reqMilestone->save();
        }
        else if ($offer->amount < $offer->listing->budget) {
            $milestones = $offer->listing->budgetDetails()->get();
            $amountToSub = ($offer->listing->budget - $offer->amount)/$milestones->count();

            foreach ($milestones as $milestone) {
                $milestone->budget = round($milestone->budget - $amountToSub, 2);

                $milestone->save();
            }
        }

        $offer->listing->budget = $offer->amount;

        $offer->listing->save();

        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $offer->user_id;
        $message->listing_id    = $offer->listing_id;
        $message->message       = '<p>Congratulations! Your Offer is accepted.</p>';
        $message->save();

        return Reply::success('You have successfully accepted offer');
    }

    public function declineOffer($id)
    {
        $offer = Offer::find($id);
        $offer->status = 'rejected';
        $offer->save();

        $listing = Listing::find($offer->listing_id);
		$listing->assigned = 'no';
		$listing->status = 'pending';
		$listing->save();
		
        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $offer->user_id;
        $message->listing_id    = $offer->listing_id;
        $message->message       = '<p>Your offer was not accepted. Send a better one. <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'" style="color:#fff !important;">'. $listing->job_title .'</a></div></p>';
        $message->save();

        return Reply::success('You have successfully decline offer');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->pageTitle = trans('menu.postListing');
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
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
        $this->categories = Category::all();
        return view('user/listing/edit', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copyListing($id)
    {
        $this->pageTitle = trans('menu.postListing');
        $this->listing = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
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
        $this->categories = Category::all();
        return view('user/listing/copy-list', $this->data);
    }

    public function update(CreateRequest $request, $id){
        if(!$request->has('budgetDate')){
            return Reply::error('Please insert at-least one milestone ');
        }
        DB::beginTransaction();
        //Listing Details store
        $listing = Listing::findOrFail($id);
        $listing->category_id    = $request->category;
        $listing->job_title      = $request->title;
        $listing->description    = $request->description;
        $listing->materials      = $request->materials;
        $listing->date_time      = Carbon::parse(max($request->budgetDate))->format('Y-m-d H:i:s');
        $listing->budget         = array_sum($request->budgetValue);
        $listing->job_location   = $request->job_location;
        $listing->immediate_assistance   = $request->immediate_assistance;
        $listing->address        = $request->address;
        $listing->street_address = $request->street_address;
        $listing->city           = $request->city;
        $listing->state          = $request->state;
        $listing->zip_code       = $request->zip;
        $listing->user_id        = $this->user->id;
        $listing->latitude       = $request->lat;
        $listing->longitude      = $request->long;
        $listing->save();

        // Budget detail save
        if(count($request->budgetDate) > 0){
            ListingBudget::where('listing_id', $listing->id)->delete();
            foreach($request->budgetDate as $index => $budgetDate){
                $budget = $request->budgetValue;
                if($budgetDate != 0 && $budgetDate != '' && $budgetDate != null && $budget[$index] != 0 && $budget[$index] != '' && $budget[$index] != null)
                {
                    $budgetDetail = new ListingBudget();
                    $budgetDetail->date_time = Carbon::parse($budgetDate)->format('Y-m-d H:i:s');
                    $budgetDetail->budget = $budget[$index];
                    $budgetDetail->listing_id = $listing->id;
                    $budgetDetail->save();
                }

            }
        }
        DB::commit();
        return Reply::redirect(route('user.listing.index'), __('messages.listingUpdated'), $listing->id);
    }

    public function copyListingSubmit(CreateRequest $request){
        if(!$request->has('budgetDate')){
            return Reply::error('Please insert at-least one milestone ');
        }

        DB::beginTransaction();
        //Listing Details store

        $budgets = $request->budgetValue;
        $total = 0;
        foreach($budgets as $budget) {
            $total += floatval(preg_replace('/[^\d.]/', '', $budget));
        }

        $listing = new Listing();
        $listing->category_id    = $request->category;
        $listing->job_title      = $request->title;
        $listing->description    = $request->description;
        $listing->materials      = $request->materials;
        $listing->date_time      = Carbon::parse($request->date_time)->format('Y-m-d H:i:s');
        $listing->job_location   = $request->job_location;
        $listing->address        = $request->address;
        $listing->street_address = $request->street_address;
        $listing->city           = $request->city;
        $listing->state          = $request->state;
        $listing->zip_code       = $request->zip;
        $listing->user_id        = $this->user->id;
        $listing->latitude       = $request->lat;
        $listing->longitude      = $request->long;
        $listing->budget         = $total;
        $listing->save();

        // Budget detail save
        if(count($request->budgetDate) > 0){
            ListingBudget::where('listing_id', $listing->id)->delete();
            foreach($request->budgetDate as $index => $budgetDate){
                $budget = $request->budgetValue;
                if($budgetDate != 0 && $budgetDate != '' && $budgetDate != null && $budget[$index] != 0 && $budget[$index] != '' && $budget[$index] != null)
                {
                    $budgetDetail = new ListingBudget();
                    $budgetDetail->date_time = Carbon::parse($budgetDate)->format('Y-m-d H:i:s');
                    $budgetDetail->budget = floatval(preg_replace('/[^\d.]/', '', $budget[$index]));
                    $budgetDetail->listing_id = $listing->id;
                    $budgetDetail->save();
                }

            }
        }
        DB::commit();
        return Reply::success(__('messages.listingUpdated'), ['listingID' => $listing->id]);
    }

    public function destroy($id)
    {
        Listing::destroy($id);
        return Reply::success('Listing deleted successfully');
    }

    public function submitReview(\App\Http\Requests\Review\CreateRequest $request)
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
        $listing->type_as      = 'freelancer';
        $listing->user_id      = $this->user->id;
        $listing->people_id    = $list->user_id;
        $listing->save();
		
		$budgetid = ListingBudget::where('listing_id',$request->listID)->update(array(
            'status'     =>   'completed', 
		));
		
        $button = '<a href="javascript:;" onclick="showReview('.$request->listID.')" class="popup-with-zoom-anim button gray ripple-effect ico" title="Leave Feedback" data-tippy-placement="top"><i class="icon-feather-star"></i></a>';

        return Reply::success(__('messages.reviewPosted'), ['view' => $button]);
    }

    public function submitCompleteReview(\App\Http\Requests\Review\CreateRequest $request)
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
        $listing->type_as      = 'freelancer';
        $listing->user_id      = $this->user->id;
        $listing->people_id    = $list->user_id;
        $listing->save();

        $button = '<a href="javascript:;" onclick="showCompleteReview('.$request->listID .')" class="popup-with-zoom-anim button gray ripple-effect"><i class="icon-material-outline-supervisor-account"></i> View Review <span class="button-info"></span></a>';

        return Reply::success(__('messages.reviewPosted'), ['view' => $button]);
    }

    public function showReview($listing_id)
    {
        $this->listing = Listing::with(['user', 'offer' => function($q) {
            $q->with('user');
        }])->findOrFail($listing_id);

        $this->offer = $this->listing->offer->filter(function ($value, $key) {
            return $value->status == 'accepted';
        })->first();

        $this->feedback = Feedback::with(['people'])->where('user_id', $this->user->id)->where('listing_id', $this->listing->id)->get();

        $this->freelancerFeedback = $this->feedback->filter(function ($value, $key) {
            return $value->type_as == 'freelancer';
        })->first();

        $view = view('user/listing/show-review', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function showCompleteReview($listing_id)
    {
        $this->listing = Listing::with(['user', 'offer' => function($q) {
            $q->with('user');
        }])->findOrFail($listing_id);

        $this->offer = $this->listing->offer->filter(function ($value, $key) {
            return $value->status == 'accepted';
        })->first();

        $this->feedback = Feedback::with(['people'])->where('user_id', $this->user->id)->where('listing_id', $this->listing->id)->get();

        $this->freelancerFeedback = $this->feedback->filter(function ($value, $key) {
            return $value->type_as == 'freelancer';
        })->first();

        $view = view('user/listing/show-review', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }
	
	public function disputemail(DisputeCommentRequest $request)
    {
		$disputeChat = Listing::with(['user', 'offer'=>function($q){
			$q->with('user')->where('status','accepted');
		}])->where('id',$request->listing_id)->get();
		
		// print_r($disputeChat[0]->job_title.$disputeChat[0]->order_no);
		// print_r($disputeChat[0]->user->first_name.$disputeChat[0]->user->last_name);
		// print_r($disputeChat[0]->offer[0]);
		// print_r($disputeChat[0]->offer[0]->user->first_name.$disputeChat[0]->offer[0]->user->last_name);
        // The message
		// $to = "net.developer1job@gmail.com";
		// $subject = "My subject";
		// $txt = "Job Title:'".$disputeChat[0]->job_title."'\r\Order No.:'".$disputeChat[0]->order_no."'\r\Client Name:'".$disputeChat[0]->user->first_name."' '".$disputeChat[0]->user->last_name."'\r\Freelancer Name:'".$disputeChat[0]->offer[0]->user->first_name."' '".$disputeChat[0]->offer[0]->user->last_name."'";
		
		
		 Mail::send('emails', ['disputeChat' => $disputeChat], function ($m){
            $m->from('abc@gmail.com', 'Goldenflowershops');

            $m->to('net.developer1job@gmail.com')->subject('New Dispute');
        });
    }

}
