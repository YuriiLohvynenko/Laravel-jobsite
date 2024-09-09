<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Filtersdata;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends BaseController
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
//        dd($this->unseenMessages);
        $this->title = 'Home';
        $this->categories = Category::select('id', 'name', 'slug')->orderBy('name')->get();
        return view('front.home', $this->data);
    }

    public function privacy()
    {
        $this->title = 'Privacy Policy';
        return view('front.privacy', $this->data);
    }

    public function searchList(Request $request, $catID = null, $key = null)
    {
        $this->title = 'Search';
        $searchData = Listing::with(['user', 'files', 'budgetDetails', 'category', 'bookmark',
            'offer' => function($q) {
                $q->with('user');
            }]);

        if($key != 0 && $key !=  null && $key !=  'all'){
            $searchData = $searchData->where('listings.job_title', 'LIKE', '%'.$key.'%');
        }
        if($catID != 0 && $catID !=  null && $catID !=  'all'){
            $searchData = $searchData->where('listings.category_id', $catID);
        }
        $this->searchListings = $searchData->paginate(2);
        $this->key = $key;
        $this->catID = $catID;
        if ($request->ajax()) {
            $view = view('front.search-list', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }

        return view('front/search', $this->data);
    }

    public function search(Request $request, $catID = null, $key = null)
    {  
        $this->title = 'Search';
//        if($catID) {
//            $catID = explode('&', $catID);
//        }

        $perPage = 20;
        $pageNo = 1;
		
		
        if($request->has('page')){
            $pageNo = $request->page;
        }
        //selectRaw('listings.*, users.* listing_files.*, listing_budget_date.*, categories.*, bookmark.*, ( select sum(budget) from `listing_budget_date` where `listing_id` = `listings`.`id`) AS budgetamount')
		// print_r($pageNo);
		// die();
		$count = Listing::where('date_time', '>=', Carbon::now('Asia/Kolkata'));
        $searchData = Listing::with([
                'user', 'files',
                'budgetDetails' => function ($q) {
                    $q->orderBy('date_time');
                },
                'category', 'bookmark' => function ($query) {
                    ($this->user) ? $query->where('user_id', $this->user->id) : $query ;
                },
                'offer' => function($q) {
                    $q->with('user');
            }])->where('date_time', '>=', Carbon::now('Asia/Kolkata'));
				// print_r($searchData->count());
				// die();
        if(!is_null($key) && !$request->ajax()){
            $searchData = $searchData->where('job_title', 'LIKE', '%'.$key.'%');
        }

        if($catID !=  null &&  !$request->ajax()){
            $searchData = $searchData->whereHas('category', function ($q) use ($catID){
                $q->where('slug', $catID);
            });
        }
		
        $data = [
            'pageNo' => $pageNo,
            'perPage' => $perPage,
            'key' => $key,
            'catID' => $catID
        ];
			
        if ($request->ajax()) {
            // filter results
            // by radial distance
            if ($request->location != null && $request->radius != null) {
                if ($request->location !== 'remote') {
                    $searchData = $searchData->selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) )
                    * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance', [$request->location['lat'],$request->location['lng'],$request->location['lat']])
                            ->whereRaw('longitude BETWEEN longitude-?/ABS(COS(RADIANS(latitude))*69) AND longitude+?/ABS(COS(RADIANS(latitude))*69)', [$request->radius, $request->radius])
                            ->whereRaw('latitude BETWEEN latitude-(?/69) AND latitude+(?/69)', [$request->radius, $request->radius]);
                            // ->havingRaw('distance < ?', [$request->radius]);
                }
                else {
                    $searchData = $searchData->where('job_location', 'online');
                }
            }

            // by keyword
            if($request->keyword != null){
                $searchData = $searchData
                    ->where(function ($query) use ($request) {
                    foreach ($request->keyword as $term) {
                        $query->orWhere('job_title', 'LIKE', '%' . $term . '%');
                    }
                });
            }

            // by category
            if($request->categoryID != null){
                $searchData = $searchData->whereHas('category', function ($q) use ($request){
                    $q->whereIn('id', $request->categoryID);
                });
				
            }

            // by job type
            if($request->onGoing == 'on' && $request->temporary ==  'off'){
                $searchData = $searchData->has('budgetDetails', '>', 1);
            }

            if($request->temporary == 'on' && $request->onGoing ==  'off'){
                $searchData = $searchData->has('budgetDetails', '=', 1);
            }

            // by pay range
            if($request->minimum !=  null && $request->minimum !=  ''){
                $searchData = $searchData->where('budget', '>=', $request->minimum);
            }

            if($request->maximum !=  null && $request->maximum !=  ''){
                $searchData = $searchData->where('budget', '<=', $request->maximum);
            }

            // by sortby
            if($request->sortBy != null){
                switch ($request->sortBy) {
                    case 'oldest':
                        $searchData = $searchData->orderBy('created_at', 'asc');
                    break;
                    case 'newest':
                        $searchData = $searchData->latest();
                    break;
                    case 'relevance':
                        $searchData = $searchData->orderBy('created_at', 'asc');
                    break;
                    case 'urgency':
                        $searchData = $searchData->where('immediate_assistance', 'required')->latest();
                    break;
                }
            }

            $data = Arr::add($data, 'searchData', $searchData);
			
            $this->paginate($data);
			$data = Arr::add($data, 'currentPage', $pageNo);
            $pagination = '<li class="pagination-arrow" id="previousPage"><a href="javascript:;" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li> ';
			// echo"<pre>";
				// print_r($data);
				// die();
				$this->currentPage = $pageNo;
            for ($i = 1; $i <= $this->totalPage; $i++){
                $active = ($this->currentPage == $i) ? 'current-page' : "";
                 $pagination .=   ' <li><a href="javascript:;" id="pageButtonNo'. $i .'" data-page-no="'. $i .'" class="ripple-effect page-no-button '.$active.'">'. $i .'</a></li> ';
                $active = '';
            }
            $pagination .= ' <li class="pagination-arrow" ><a href="javascript:;" id="nextPage" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
					
			$category = '';
					$keyword  = '';
					if($request->categoryID){
					if(sizeof($request->categoryID)>0){
							$category = implode(',', $request->categoryID);
					}
					}
					if($request->keyword){
					if(sizeof($request->keyword)>0){
							$keyword = implode(',', $request->keyword);
					}
					}
			$row = Filtersdata::where('user_id','=',$request->id)->where('location','=',$request->location)->where('radius','=',$request->radius)->where('keywords','=',$keyword)->where('category','=',$category)->where('on_going','=',$request->onGoing)->where('temporary','=',$request->temporary)->where('pay_range_start','=',$request->minimum)->where('pay_range_end','=',$request->maximum);
			if($row->count() == 0){
				$view = view('front.search-list', $this->data)->render();
            return Reply::dataOnly(['view' => $view, 'pagination' => $pagination, 'listings' => $this->searchListings]);
			}else{
				$data = $row->get();
				$view = view('front.search-list', $this->data)->render();
            return Reply::dataOnly(['view' => $view, 'pagination' => $pagination, 'listings' => $this->searchListings, 'status'=>$data[0]->text_alert_status]);
			}
        }

        $data = Arr::add($data, 'searchData', $searchData);

        $this->paginate($data);
		$this->currentPage = $pageNo;
        return view('front.search', $this->data)->with('listings', $this->searchListings);
    }

    public function paginate($data)
    {
		// echo"<pre>";
		// print_r($data['pageNo']);
		// die();
        $this->searchListings = $this->paginationFunction($data['pageNo'],$data['perPage'],$data['searchData']);

        foreach($this->searchListings as $ideaRecords) {
            $totalRec = $ideaRecords['totalRecords'];
        }

        if(empty($totalRec) || $totalRec == 0 ){
            $totalRec = 0;
        }

        $this->totalRecord   = $totalRec;
        $this->totalPage     = ceil($totalRec / $data['perPage']);
        $this->currentPage   = $data['pageNo'];
        $start = 0;

        if($this->totalRecord){
            $start = 1;
        }

        $this->startRec   = $start;

        if($data['pageNo'] == $this->totalPage) {
            $endRec = $this->totalRecord;

        } else if($data['pageNo'] == 1){
            $endRec = $data['perPage'];

        } else{
            $endRec = (($data['pageNo'] - 1) * $data['perPage']) + $data['perPage'];
        }

        $this->endRec   = $endRec;
        $this->key = $data['key'];
        $this->categories = Category::select('id', 'name', 'slug')->orderBy('name')->get();
//        $this->catID = $catID ? implode('&', $catID) : null;
        $this->catID = $data['catID'];
    }

    public function paginationFunction($pageNo, $perPage, $dataDetail)
    {
        if ($pageNo == 1) {
            $offset = 0;
        } else {
            $offset = ($pageNo - 1) * $perPage;
        }
		$totalRecords = $dataDetail->count();
        $askDetailPagination = $dataDetail->skip($offset)
            ->take($perPage)
            ->get();

        // print_r($askDetailPagination->count());
		// die();

        foreach ($askDetailPagination as $askDetailPaginations) {
            $askDetailPaginations['totalRecords'] = $totalRecords;
        }

        return $askDetailPagination;
    }
	
	public function savefilter(Request $request)
    {
		// if($request->count() > 0){
			$category = '';
			$keyword  = '';
			if($request->check == 'true'){
				$check = 1;
			}elseif($request->check == 'false'){
				$check = 0;
			}
			if(sizeof($request->categoryID)>0){
					$category = implode(',', $request->categoryID);
			}
			if(sizeof($request->keyword)>0){
					$keyword = implode(',', $request->keyword);
			}
			$row = Filtersdata::where('user_id','=',$request->id)->where('location','=',$request->location)->where('radius','=',$request->radius)->where('keywords','=',$keyword)->where('category','=',$category)->where('on_going','=',$request->onGoing)->where('temporary','=',$request->temporary)->where('pay_range_start','=',$request->minimum)->where('pay_range_end','=',$request->maximum);
			$data = $row->get();
			if($row->count() == 0){
			$table = new Filtersdata();
			$table->user_id = $request->id;
			$table->location = $request->location;
			$table->radius = $request->radius;
			$table->keywords = $keyword;
			$table->category = $category;
			$table->on_going = $request->onGoing;
			$table->temporary = $request->temporary;
			$table->pay_range_start = $request->minimum;
			$table->pay_range_end = $request->maximum;
			$table->text_alert_status = $check;
			$table->save();
			}elseif($data[0]->text_alert_status == $check){
				return Reply::success('Filters already taken');	
			}else{
				
				$table = new Filtersdata();
				$table = Filtersdata::where('user_id','=',$request->id)->update(array('text_alert_status' => $check));
				return Reply::success('Filters Updated');
			}
		// }
		return Reply::success('Filters saved');
    }
}
