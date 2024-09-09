<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Badges\LicensedBadgesRequest;
use App\Http\Requests\Badges\StoreRequest;
use App\Models\Badge;
use App\Models\Bookmark;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\Message;
use App\Models\UserBadge;
use App\Notifications\BadgeVerification;
use App\Notifications\LicenseBadgeVerification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class ListingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->pageTitle = trans('menu.jobs');
        $this->jobs = Listing::with('user', 'budgetDetails', 'dispute')->paginate(10);

        return view('admin/listing/index', $this->data);
    }
    public function destroy($id)
    {
        Listing::destroy($id);
        return Reply::success(__('messages.listingDeleted'));
    }

    public function information(Request $request)
    {
        $this->listing = Listing::with(['user', 'files', 'budgetDetails' => function($q) {
            $q->with('increase_history');
        }, 'category', 'bookmark','selectedOffers' => function($q) {
            $q->with('user');
        }])->find($request->id);

        $view = view('admin/listing/information', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }


    public function contactUser($id){
        $this->contactUser = User::find($id);
        $view = view('admin/users/messages-popup', $this->data)->render();
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

}
