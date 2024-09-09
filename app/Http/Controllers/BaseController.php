<?php

namespace App\Http\Controllers;


use App\Models\Message;

class BaseController extends Controller
{

    /**
	 * @var array
	 */
    public $data = [];

    /**
	 * @param $name
	 * @param $value
	 */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

     /**
	 * @param $name
	 * @return mixed
	 */
    public function __get($name)
    {
        return $this->data[$name];
    }

     /**
	 * @param $name
	 * @return bool
	 */
    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        // Inject currently logged in user object into every view of user dashboard
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('job-seeker')->user();
            if ($this->user){
                $this->unseenMessages = Message::with('fromuser')
                    ->where('to_user', $this->user->id)
					->join('users','messages.user_id','=','users.id')
                    ->where('messages.message_seen', 'no')
                    ->orderBy('messages.created_at', 'DESC')
                    ->get();
                $this->unseenMessages = $this->unseenMessages->unique(function ($item) {
                    return $item['user_id'].$item['to_user'];
                });
                $this->unseenMessages->values()->all();
            }
            return $next($request);
        });



        \App::setLocale('en');
    }

}
