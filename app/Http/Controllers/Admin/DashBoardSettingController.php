<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProfileSettingRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\GlobalSettings;
use App\Models\Specialities;
use App\Models\UserSpecialities;
use App\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DashBoardSettingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->global = GlobalSettings::first();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.dashboardSetting');
//        $this->specialities = Specialities::all();
//        $this->userSpecialities = UserSpecialities::where('user_id', $this->user->id)->pluck('speciality_id');
//        $this->userDetail = $this->user->detail;
//        $this->previousTitles = ($this->userDetail->previous_job_titles != null) ? \GuzzleHttp\json_decode($this->userDetail->previous_job_titles) : [] ;

        return view('admin/dashboard/dashboard-setting', $this->data);
    }

    /**
     * @param ProfileSettingRequest $request
     * @param $id
     * @return array
     */
    public function update(ProfileSettingRequest $request,  $id)
    {
        // User Update
        $user                = $this->user;
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
        $user->email         = $request->email;

        if($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            File::delete('public/avatar' . $user->image);

            $user->image = $request->image->hashName();
            $request->image->store('public/avatar');
        }

        // User Detail Update
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->state           = $request->state;
        $user->zip_code        = $request->zip_code;
        $user->mobile_number   = $request->mobile_number;
        $user->save();

        if($request->commission_rate) {
            $this->global->commission_rate = $request->commission_rate;
        }

        if($request->cashback_rate) {
            $this->global->cashback_rate = $request->cashback_rate;
        }
        $this->global->save();
        return Reply::success(__('messages.ProfileSettingUpdated'), ['image' => $user->image()]);

    }
}
