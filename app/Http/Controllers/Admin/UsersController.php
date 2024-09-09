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

class UsersController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->pageTitle = trans('menu.users');
        return view('admin/users/index', $this->data);
    }

    public function data()
    {
        $users = User::select(DB::raw("CONCAT(users.first_name,' ',users.last_name) as name"),'id', 'username', 'status')->with( 'disputes');
        return DataTables::of($users)
            ->addColumn('action', function ($row) {
                $action = '<div class="tabs-jobs-buttons">
                                <a href="javascript:;" onclick="openModal('.$row->id.', \'small-dialog-1\')" class="popup-with-zoom-anim button ripple-effect" data-tippy-placement="top" data-tippy="" data-original-title="View Profile"><i class="icon-feather-download-cloud"></i></a>
                                <a href="'.route('user.profile.show', $row->id).'" class="button gray ripple-effect" data-tippy-placement="top" data-tippy="" data-original-title="View Public Profile"><i class="icon-feather-user"></i></a>
                                <a href="javascript:;" onclick="contactUser('. $row->id .')" class="popup-with-zoom-anim button gray ripple-effect" data-tippy-placement="top" data-tippy="" data-original-title="Contact User"><i class="icon-feather-message-square"></i></a>
                            </div>';
                return $action;
            })
            ->addColumn('rating', function ($row) {
                return $row->userRating();
            })
            ->addColumn('reports', function ($row) {
                return '0';
            })
            ->addColumn('disputes', function ($row) {
                return $row->disputes->count();
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->editColumn('status', function ($row) {
                if($row->status == 1) {
                     return 'Active';
                } else {
                    return 'Disabled';
                }
            })
            ->make(true);
    }

    public function destroy($id)
    {
        Bookmark::destroy($id);
        return Reply::success(__('messages.bookmarkDeleted'));
    }

    public function information(Request $request)
    {
        $this->user = User::with('badge', 'detail')->find($request->id);

        $view = view('admin/users/information', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }
    public function getConfirmation(Request $request)
    {
        $this->badge = UserBadge::find($request->badgeId);
        $view = view('admin/users/confirmation', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return Reply::success('Status successfully changed.');
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
