<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Specialities;
use App\Models\UserSpecialities;
use App\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DashBoardSettingController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.dashboardSetting');
        $this->specialities = Specialities::all();
        $this->userSpecialities = UserSpecialities::where('user_id', $this->user->id)->pluck('speciality_id');
        $this->userDetail = $this->user->detail;
        $this->previousTitles = ($this->userDetail->previous_job_titles != null) ? \GuzzleHttp\json_decode($this->userDetail->previous_job_titles) : [] ;
        return view('user/dashboard/dashboard-setting', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(ProfileUpdateRequest $request,  $id)
    {
		
        $previousJobTitle = null;
        if(count($request->previous_job_title) != 0){
            $previousJobTitle = \GuzzleHttp\json_encode($request->previous_job_title);
        }
        // User Update
        $user                = $this->user;
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
       $user->email         = $request->encryptemail;

        if($request->new_password){
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            File::delete('public/avatar' . $user->image);

            $user->image = $request->image->hashName();
            $request->image->store('public/avatar');
        }
        $user->save();

        // User Speciality update
        if(count($request->speciality) != 0){
            UserSpecialities::where('user_id', $user->id)->delete();

            foreach($request->speciality as $speciality){
                $userSpeciality = new UserSpecialities();
                $userSpeciality->user_id = $user->id;
                $userSpeciality->speciality_id = $speciality;
                $userSpeciality->save();
            }
        }

        // User Detail Update
        $userDetail = $this->user->detail;
        $userDetail->paypal_email    = $request->paypal_email;
        $userDetail->hourly_rate     = $request->hourly_rate;
        $userDetail->address         = $request->address;
        $userDetail->city            = $request->city;
        $userDetail->state           = $request->state;
        $userDetail->zip_code        = $request->zip_code;
        $userDetail->mobile_no       = rawurlencode(urlencode(base64_encode($request->mobile_no)));
        $userDetail->previous_job_titles    = $previousJobTitle;
        $userDetail->introduction           = trim($request->profileIntroduction);
        $userDetail->save();

        return Reply::success(__('messages.ProfileSettingUpdated'), ['image' => $user->image()]);

    }
}
