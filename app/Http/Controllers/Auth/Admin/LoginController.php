<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Auth\LoginRequest;

class LoginController extends AdminBaseController
{

     /**
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */

    public function index()
    {
        $this->pageTitle = trans('core.login');
        // If a user is already logged in, redirect to dashboard Page
        if(auth()->guard('admin')->check()) {
            return \Redirect::route('admin.dashboard.index');
        }

        return view('auth/admin-login', $this->data);
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

        if (auth()->guard('admin')->attempt($credentials, $remember)) {
            // User login success
            return Reply::redirect(route('admin.dashboard.index'), 'messages.loginSuccess');

        }

        // Login Failed
        return Reply::error('messages.loginFail');


//        return Reply::error('messages.accountDisableMessage');
    }

//    public function redirect($provider)
//    {
//        return Socialite::driver($provider)->redirect();
//    }
//
//    public function callback($provider)
//    {
//        $data = Socialite::driver($provider)->user();
//
//        $name = explode(' ',$data->name);
//        $information = [
//            'username'  => $name[0].'_'.$name[1].'_'.str_random(5),
//            'first_name'  => $name[0],
//            'last_name'  => $name[1],
//            'password'  => bcrypt($name[0]),
//            'email' => $data->email,
//        ];
//
//        $user = User::where('email', '=', $data->email)->first();
//
//        if ($user === null) {
//            // Log in first time with social
//            \DB::beginTransaction();
//
//            $userData = User::create($information);
//
//            $userDetail = new UserDetail();
//            $userDetail->user_id = $userDetail->id;
//            $userDetail->save();
//
//            Social::create([
//                'user_id' => $userData->id,
//                'social_id' => $data->id,
//                'social_service' => $provider,
//            ]);
//
//            \DB::commit();
//
//            \Auth::guard('admin')->login($userData);
//
//            return Redirect::route('user.dashboard.index');
//        }
//        else {
//
//            // User found
//            \DB::beginTransaction();
//
//            Social::where('user_id', '=', $user->id)
//                ->update([
//                    'social_id' => $data->id,
//                    'social_service' => $provider,
//                ]);
//
//            \DB::commit();
//
//            \Auth::guard('admin')->login($user);
//
//            return Redirect::route('user.dashboard.index');
//        }
//    }
//
//    /**
//     * @param RegisterRequest $request
//     * @return array
//     */
//    public function postRegister(RegisterRequest $request)
//    {
//        \DB::beginTransaction();
//
//        $user               = new User();
//        $user->first_name    = $request->first_name;
//        $user->last_name     = $request->last_name;
//        $user->username     = $request->username;
//        $user->email        = $request->email;
//        $user->password = bcrypt($request->password);
//
//        $user->save();
//        $detail               = new UserDetail();
//        $detail->user_id = $user->id;
//        $detail->save();
//
//        \DB::commit();
//
//        $msg = trans('messages.signUpSuccess');
//
//        return Reply::success($msg);
//    }
//
//    /**
//     * @return \Illuminate\Contracts\View\View
//     */
//    public function getReset ()
//    {
//        $this->pageTitle = trans('core.resetPassword');
//        return view('auth.forget', $this->data);
//    }
//
//    public function postReset(ForgetPasswordRequest $request)
//    {
//        $email = $request->email;
//        $user  = User::where('email', $email)->first();
//
//        $passwordResetCode = str_random(40);
//        $user->reset_token = $passwordResetCode;
//        $user->save();
//
//        $user->notify(new ForgetPassword());
//
//        $msg = trans('messages.resetPasswordLink', ['here' => '<a href="' . route('user.login') . '">Here</a>']);
//
//        return Reply::success($msg);
//    }
//
//    /**
//     * @return \Illuminate\Contracts\View\View
//     */
//    public function getPasswordReset($token)
//    {
//        $this->pageTitle = trans('core.resetPassword');
//        $this->passwordResetCode = $token;
//        $user = User::where('reset_token', $this->passwordResetCode)->first();
//
//        if($user) {
//            return view('auth.reset-password', $this->data);
//
//        } else {
//            $this->error = trans('messages.passwordTokenNotMatch', ['here' => '<a href="' . route('user.get-reset') . '">Here</a>']);
//
//            return view('auth.reset-password', $this->data);
//        }
//    }
//
//    /**
//     * Post Password Reset
//     * @param Requests\Front\ChangePasswordRequest $request
//     * @return array
//     */
//    public function postPasswordReset(ChangePasswordRequest $request)
//    {
//        $passwordResetCode = $request->passwordResetCode;
//
//        $user = User::where('reset_token', $passwordResetCode)->first();
//
//        if($user) {
//            $user->password = bcrypt($request->password);
//            $user->reset_token = null;
//            $user->save();
//
//            $msg = trans('messages.changePasswordSuccess', ['here' => '<a href="' . route('user.login') . '">Here</a>']);
//
//            return Reply::success($msg);
//
//        } else {
//            $msg = trans('messages.passwordTokenNotMatch', ['here' => '<a href="' . route('user.get-reset') . '">Here</a>']);
//            return Reply::error($msg);
//        }
//    }

     /**
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function logout()
    {
         auth()->guard('admin')->logout();
         return \Redirect::route('front.home');
    }

}
