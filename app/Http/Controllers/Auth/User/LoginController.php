<?php

namespace App\Http\Controllers\Auth\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Front\ChangePasswordRequest;
use App\Http\Requests\Front\ForgetPasswordRequest;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Front\RegisterRequest;

use App\Models\Social;
use App\Models\UserDetail;
use App\Notifications\ForgetPassword;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends BaseController
{

     /**
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */

    public function index()
    {
        $this->pageTitle = trans('core.login');
        // If a user is already logged in, redirect to dashboard Page
        if(auth()->guard('job-seeker')->check()) {
            return \Redirect::route('user.dashboard.index');
        }

        return view('auth/login-register', $this->data);
    }

    /**
     * @param LoginRequest $request
     * @return array
     */

    public function ajaxLogin(LoginRequest $request)
    {
		
        $username = $request->get('email');
        $password   = $request->get('password');

        // Credentials to check user login
        $credentials = ['email' => $username, 'password' => $password];
        $remember    = $request->remember ? true : false;

        $user = User::where('email', $username)->first();

        if($user && $user->status != 1) {
            return Reply::error('Your account is temporally blocked. Contact to administrator to active your account');
        }

        if (auth()->guard('job-seeker')->attempt($credentials, $remember)) {
            // User login success
            return Reply::redirect(route('user.dashboard.index'), 'messages.loginSuccess');

        }

        // Login Failed
        return Reply::error(__('messages.loginFail'));


//        return Reply::error('messages.accountDisableMessage');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $name = explode(' ',$data->name);
        $information = [
            'username'  => $name[0].'_'.$name[1].'_'.str_random(5),
            'first_name'  => $name[0],
            'last_name'  => $name[1],
            'password'  => bcrypt($name[0]),
            'email' => $data->email,
        ];

        $user = User::where('email', '=', $data->email)->first();

        if ($user === null) {
            // Log in first time with social
            \DB::beginTransaction();

            $userData = User::create($information);

            $userDetail = new UserDetail();
            $userDetail->user_id = $userDetail->id;
            $userDetail->save();

            Social::create([
                'user_id' => $userData->id,
                'social_id' => $data->id,
                'social_service' => $provider,
            ]);

            \DB::commit();

            \Auth::guard('job-seeker')->login($userData);

            return Redirect::route('user.dashboard.index');
        }
        else {

            // User found
            \DB::beginTransaction();

            Social::where('user_id', '=', $user->id)
                ->update([
                    'social_id' => $data->id,
                    'social_service' => $provider,
                ]);

            \DB::commit();

            \Auth::guard('job-seeker')->login($user);

            return Redirect::route('user.dashboard.index');
        }
    }

    /**
     * @param RegisterRequest $request
     * @return array
     */
    public function postRegister(RegisterRequest $request)
    {
        \DB::beginTransaction();

        $user               = new User();
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
        $user->username     = $request->username;
        $user->email        = rawurlencode(urlencode(base64_encode($request->email)));
        $user->password = bcrypt($request->password);

        $user->save();
        $detail               = new UserDetail();
        $detail->user_id = $user->id;
        $detail->save();

        \DB::commit();

        $msg = trans('messages.signUpSuccess');

        return Reply::success($msg);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getReset ()
    {
        $this->pageTitle = trans('core.resetPassword');
        return view('auth.forget', $this->data);
    }

    public function postReset(ForgetPasswordRequest $request)
    {
        $email = $request->email;
        $user  = User::where('email', $email)->first();

        $passwordResetCode = str_random(40);
        $user->reset_token = $passwordResetCode;
        $user->save();

        $user->notify(new ForgetPassword());

        $msg = trans('messages.resetPasswordLink', ['here' => '<a href="' . route('user.login') . '">Here</a>']);

        return Reply::success($msg);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getPasswordReset($token)
    {
        $this->pageTitle = trans('core.resetPassword');
        $this->passwordResetCode = $token;
        $user = User::where('reset_token', $this->passwordResetCode)->first();

        if($user) {
            return view('auth.reset-password', $this->data);

        } else {
            $this->error = trans('messages.passwordTokenNotMatch', ['here' => '<a href="' . route('user.get-reset') . '">Here</a>']);

            return view('auth.reset-password', $this->data);
        }
    }

    /**
     * Post Password Reset
     * @param Requests\Front\ChangePasswordRequest $request
     * @return array
     */
    public function postPasswordReset(ChangePasswordRequest $request)
    {
        $passwordResetCode = $request->passwordResetCode;

        $user = User::where('reset_token', $passwordResetCode)->first();

        if($user) {
            $user->password = bcrypt($request->password);
            $user->reset_token = null;
            $user->save();

            $msg = trans('messages.changePasswordSuccess', ['here' => '<a href="' . route('user.login') . '">Here</a>']);

            return Reply::success($msg);

        } else {
            $msg = trans('messages.passwordTokenNotMatch', ['here' => '<a href="' . route('user.get-reset') . '">Here</a>']);
            return Reply::error($msg);
        }
    }

     /**
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function logout()
    {
         auth()->guard('job-seeker')->logout();
         return \Redirect::route('front.home');
    }

}
