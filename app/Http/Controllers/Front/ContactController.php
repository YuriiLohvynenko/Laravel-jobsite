<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Front\ContactRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = 'Contact';
    }

    public function index()
    {
        if(auth()->guard('job-seeker')->check()) {
            $this->user = auth()->guard('job-seeker')->user();
        }

        return view('front/contact', $this->data);
    }

    public function save(ContactRequest $request)
    {
        if(auth()->guard('job-seeker')->check()) {
            $this->user = auth()->guard('job-seeker')->user();
        }
        $name = (!is_null($this->user))? $this->user->first_name.' '.$this->user->last_name : '' ;
        $email = (!is_null($this->user))? $this->user->email: '' ;
        \DB::beginTransaction();
        $contact            = new ContactUs();
        $contact->name      = $name;
        $contact->email     = $email;
        $contact->subject   = $request->subject;
        $contact->message   = $request->message;

        $contact->save();

        \DB::commit();

        $msg = trans('messages.contactSuccessfully');

        return Reply::success($msg);
    }
}
