<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\BaseController;
use App\Models\Badge;
use App\Models\Dispute;
use App\Models\Listing;
use App\Models\ListingBudget;
use App\Models\Notification;
use App\Models\UserBadge;
use App\User;
use Carbon\Carbon;

class DashBoardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'Dashboard';
        $this->totalUser = User::all()->count();
        $this->totalBadgeRequest = UserBadge::where('status', 'pending')->count();
        $this->totalOpenDispute = Dispute::where('status', 'pending')->count();
        $this->totalListings = Listing::count();
        $this->totalCompletedListings = Listing::where('status', 'completed')->count();
        $this->unreadNotifications = Notification::whereNull('read_at')->get();

        return view('admin/dashboard/dashboard', $this->data);
    }
}
