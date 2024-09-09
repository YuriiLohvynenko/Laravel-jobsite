<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Badges\LicensedBadgesRequest;
use App\Http\Requests\Badges\StoreRequest;
use App\Models\Badge;
use App\Models\Bookmark;
use App\Models\Feedback;
use App\Models\UserBadge;
use App\Notifications\BadgeVerification;
use App\Notifications\ContactUsMail;
use App\Notifications\LicenseBadgeVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BadgesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.badges');
        $badges = Badge::all();

        $this->verification = $badges->filter(function ($item) {
            return $item->type == 'verification';
        });

        $this->licensed = $badges->filter(function ($item) {
            return $item->type == 'licensed';
        });
        return view('user/badges/index', $this->data);
    }

    public function destroy($id)
    {
        Bookmark::destroy($id);
        return Reply::success(__('messages.bookmarkDeleted'));
    }

    public function getBadges(Request $request)
    {
        $this->id = $request->id;
        $this->popup_id = $request->popup_id;

        $licensedBadges = Badge::where('type', 'licensed')->pluck('id')->toArray();

        if($request->id == 1) {
            $view = view('user/badges/true-your-badge', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        else if($request->id == 2) {
            $view = view('user/badges/digital-id-badge', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        else if($request->id == 3) {
            $view = view('user/badges/background-check-badge', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        else if($request->id == 4) {
            $view = view('user/badges/mobile-badge', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
        else if(in_array($request->id, $licensedBadges)) {
            $view = view('user/badges/licensed-badges', $this->data)->render();
            return Reply::dataOnly(['view' => $view]);
        }
    }

    public function submitBadges(StoreRequest $request)
    {
        DB::beginTransaction();

        $this->id = $request->badge_id;

        if($request->first_name) {
            $this->user->first_name = $request->first_name;
        }

        if($request->last_name) {
            $this->user->last_name = $request->last_name;
        }

        if($request->email) {
            $this->user->email = $request->email;
        }

        $this->user->save();

        $userBadge = new UserBadge();

        if($request->has('file')) {
            $request->file->store('public/documents');

            $fileName = $request->file->hashname();

            $userBadge->file = $fileName;
        }

        $userBadge->user_id = $this->user->id;
        $userBadge->badge_id = $request->badge_id;

        if($request->package_check) {
            $userBadge->package_check = $request->package_check;
        }
        if($request->radio) {
            $userBadge->document_type = $request->radio;
        }

        if($request->job_title) {
            $userBadge->job_title = $request->job_title;
        }

        $userBadge->save();

        Notification::route('mail', env('ADMIN_EMAIL'))
            ->notify(new BadgeVerification($this->user, $userBadge));


        DB::commit();

        return Reply::redirect(route('user.badges.index'), 'Badge successfully added');
    }

    public function submitLicensedBadges(LicensedBadgesRequest $request)
    {
        $userBadge = new UserBadge();
        $userBadge->user_id = $this->user->id;
        $userBadge->badge_id = $request->badge_id;
        $userBadge->license_no = $request->license_no;

        if($request->description) {
            $userBadge->description = $request->description;
        }

        $userBadge->save();

        $userBadge->name = $request->name;

        Notification::route('mail', env('ADMIN_EMAIL'))
            ->notify(new LicenseBadgeVerification($this->user, $userBadge));

        return Reply::redirect(route('user.badges.index'), 'Badge successfully added');
    }
}
