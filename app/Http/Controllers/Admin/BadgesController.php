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

class BadgesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {

        $this->pageTitle = trans('menu.badges');
        $this->badges = User::select('users.id as userId','user_badges.id as badgeId', 'users.first_name',
            'users.last_name', 'badges.name', DB::raw('(select count(id) as id from user_badges where status="verified" and user_id=userId) as count'))
            ->join('user_badges', 'user_badges.user_id', '=', 'users.id')
            ->leftJoin('badges', 'user_badges.badge_id', '=', 'badges.id')
            ->where('user_badges.status', 'pending')
            ->groupBy('badges.name', 'users.id', 'user_badges.id', 'first_name', 'last_name', 'name')->paginate(10);

        return view('admin/badges/index', $this->data);
    }

    public function destroy($id)
    {
        Bookmark::destroy($id);
        return Reply::success(__('messages.bookmarkDeleted'));
    }

    public function contactUser($id){
        $this->contactUser = User::find($id);
        $view = view('admin/badges/messages-popup', $this->data)->render();
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

    public function getVerify(Request $request)
    {
        $badges = UserBadge::where('user_id', $request->id)->get();
        $this->pending = $badges->filter(function ($value, $key) {
            return $value->status == 'pending';
        });

        $this->accepted = $badges->filter(function ($value, $key) {
            return $value->status == 'verified';
        });

        $this->badge = UserBadge::find($request->badgeId);

        $view = view('admin/badges/verify', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function badgeDetail(Request $request)
    {
        $this->badge = UserBadge::find($request->badgeId);

        $view = view('admin/badges/detail', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function approve(Request $request)
    {
        $this->badge = UserBadge::find($request->badgeId);
        $this->badge->status = 'verified';

        $this->badge->save();

        $badges = UserBadge::where('user_id', $this->badge->user->id)->get();
        $this->pending = $badges->filter(function ($value, $key) {
            return $value->status == 'pending';
        });

        $this->accepted = $badges->filter(function ($value, $key) {
            return $value->status == 'verified';
        });

        $this->badge = UserBadge::find($request->badgeId);

        $view = view('admin/badges/verify', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function reject(Request $request)
    {
        $this->badge = UserBadge::find($request->badgeId);
        $this->badge->status = 'rejected';

        $this->badge->save();

        $badges = UserBadge::where('user_id', $this->badge->user->id)->get();
        $this->pending = $badges->filter(function ($value, $key) {
            return $value->status == 'pending';
        });

        $this->accepted = $badges->filter(function ($value, $key) {
            return $value->status == 'verified';
        });

        $this->badge = UserBadge::find($request->badgeId);

        $view = view('admin/badges/verify', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function getConfirmation(Request $request)
    {
        $this->badge = UserBadge::find($request->badgeId);
        $view = view('admin/badges/confirmation', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function remove(Request $request)
    {
        $this->badge = UserBadge::destroy($request->badgeId);
        return Reply::success('Badge successfully removed');
    }
}
