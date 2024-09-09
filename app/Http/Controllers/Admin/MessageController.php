<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Models\Dispute;
use App\Models\Message;
use App\Models\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->pageTitle = trans('menu.message');
        $threads = Thread::with('listing')->whereNotNull('listing_id')->get();
        $messageList = [];
        foreach ($threads as $key => $thread){
            $messageList[$key]['thread_id'] = $thread->id;
            $messageList[$key]['listing_id'] = $thread->listing->order_no;
            $messageList[$key]['client'] = $thread->listing->user->first_name. ' ' .$thread->listing->user->last_name;
            if ($thread->user_id == $thread->listing->user_id){
                $messageList[$key]['freelancer'] = $thread->touser->first_name. ' ' .$thread->touser->last_name;
            }
            else{
                $messageList[$key]['freelancer'] = $thread->fromuser->first_name. ' ' .$thread->fromuser->last_name;
            }
            $messageList[$key]['thread_count'] = Message::where('threads_id', $thread->id)->count();
            $messageList[$key]['dispiute'] = Dispute::where('listing_id', $thread->listing_id)->count() > 0 ? 'yes' : 'No';
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($messageList);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());

        $this->messageList = $paginatedItems;

        return view('admin.messages.index', $this->data);
    }

    public function showThread($id){
        $this->thread = Thread::find($id);
        $this->messages = Message::where('threads_id', $id)->get();
        $this->messages = $this->messages->unique(function ($item) {
            return $item['message'];
        });
        $this->messages->values()->all();
        $this->adminUser = User::where('username', 'admin')->first();
        $view = view('admin/messages/show-thread', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }
    public function changeStatus($status, $id){
        $thread = Thread::find($id);
        $thread->chat_status = $status;
        $thread->save();
        return Reply::success('Chat Status has been '.$status);
    }

    public function sendMessage(Request $request, $id){
        $adminUser = User::where('username', 'admin')->first();
        $thread = Thread::find($id);
        $message = new Message();
        $message->user_id       = $adminUser->id;
        $message->to_user       = $thread->user_id;
        $message->message       = $request->message;
        $message->save();

        $message = new Message();
        $message->user_id       = $adminUser->id;
        $message->to_user       = $thread->to_user;
        $message->message       = $request->message;
        $message->save();
        return Reply::success('Message Send successfully.');
    }
}
