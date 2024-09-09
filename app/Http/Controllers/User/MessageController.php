<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Listing\CreateRequest;
use App\Models\Dispute;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = trans('menu.message');
        $this->messageUsers = $this->usersList();
        if ($this->messageUsers->count()){
//            $this->allMessage = $this->chatDetails($this->messageUsers->first()->id, $this->user->id);
            $this->allMessage = $this->chatDetail($this->messageUsers->first()->id, $this->user->id);
        }
        else{
            $this->allMessage = collect([]);
        }

        return view('user.message.index', $this->data);
    }

    public function messageSearch($term){
        if ($term == 'all'){
            $this->messageUsers = $this->usersList();
        }
        else{
            $this->searchMessages = User::select('users.*', 'messages.listing_id', 'messages.threads_id', 'messages.message', 'messages.user_id', 'messages.to_user', 'messages.created_at as message_created_at')
                ->join('messages', 'messages.user_id', 'users.id')
                ->where('messages.deleted_at', null)
                ->where('messages.message', 'like', '%'.$term.'%')
                ->orWhere('users.first_name', 'like', '%'.$term.'%')
                ->orWhere('users.last_name', 'like', '%'.$term.'%')
                ->get();
            $this->searchMessages = $this->searchMessages->unique(function ($item) {
                return $item['user_id'].$item['to_user'];
            });
            $this->searchMessages->values()->all();
//            dd($this->searchMessages);
            foreach ($this->searchMessages as $messageUser){
                $fromUser = 0;
                if ($messageUser->id == $this->user->id){
                    $fromUser = $messageUser->to_user;
                }
                else{
                    $fromUser = $messageUser->id;
                }
//                $lastMessage = $this->getLastMessage($fromUser, $this->user->id);
                $lastMessage = $this->getLastMessages($messageUser->threads_id);
                if ($lastMessage){
                    $messageUser->message = $lastMessage->message;
                    $messageUser->message_created_at = $lastMessage->created_at;
                }
                else{
                    $messageUser->message = '';
                    $messageUser->message_created_at = '';
                }
            }
            $this->messageUsers = $this->searchMessages;
        }
        $view = view('user/message/load-users', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function usersList(){
        $usersList = User::select('users.*', 'messages.listing_id', 'messages.threads_id', 'messages.message', 'messages.created_at as message_created_at')
            ->join('messages', 'messages.user_id', 'users.id')
            ->where('messages.to_user', $this->user->id)
            ->get();
        $usersList = $usersList->unique('id');
        $usersList->values()->all();

        foreach ($usersList as $messageUser){
//            $lastMessage = $this->getLastMessage($messageUser->id, $this->user->id);
            $lastMessage = $this->getLastMessages($messageUser->threads_id);
            if ($lastMessage){
                $messageUser->message = $lastMessage->message;
                $messageUser->message_created_at = $lastMessage->created_at;
            }
            else{
                $messageUser->message = '';
                $messageUser->message_created_at = '';
            }

        }

        $usersList = $usersList->sortByDesc('message_created_at');
        return $usersList;
    }

    public function chatDetails($from, $to){
        $updateData = ['message_seen' => 'yes'];
        Message::messageSeenUpdate($this->user->id, $from, $updateData);
		
        return Message::with('fromuser')
            ->where(function($query) use ($from, $to){
                $query->where('user_id', $from)
                    ->where('to_user', $to)
                    ->orWhere(function($q) use ($from, $to) {
                        $q->where('to_user', $from)
                        ->where('user_id', $to);
                    });
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function chatDetail($from, $to){
        $thread = Thread::where(function($query) use ($from, $to){
            $query->where('user_id', $from)
                ->where('to_user', $to)
                ->orWhere(function($q) use ($from, $to) {
                    $q->where('to_user', $from)
                        ->where('user_id', $to);
                });
        })
            ->first();
        $updateData = ['message_seen' => 'yes'];
        Message::messageSeenUpdate($this->user->id, $from, $updateData);
        $message =  Message::where('threads_id', $thread->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        $message = $message->unique(function ($item) {
            return $item['message'];
        });
        $message->values()->all();
        return $message;
    }

    public function readAllUnread($id){
        $updateData = ['message_seen' => 'yes'];
        Message::allMessageSeenUpdate($id, $updateData);
        return Reply::success('Marked all as read');
    }

    public function getLastMessage($from, $to){
         $message = Message::where(function($query) use ($from, $to){
                $query->where('user_id', $from)
                    ->where('to_user', $to)
                    ->orWhere(function($q) use ($from, $to) {
                        $q->where('to_user', $from)
                            ->where('user_id', $to);
                    });
            })
            ->get();
         return $message->last();
    }

    public function getLastMessages($thread){
         $message = Message::where('threads_id', $thread)
            ->get();
         return $message->last();
    }

    public function getMessages($id){
        $this->allMessage = $this->chatDetail($id, $this->user->id);
        $view = view('user/message/load-messages', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    public function acceptOffer($id, $toUser, $messageId)
    {
        $message = Message::findOrFail($messageId);
        $newMessage = explode('<div class="col-12 margin-top-20">', $message->message);
        $newMessage = $newMessage[0].'</p>';
        $message->message = $newMessage;
        $message->save();
        $offer = Offer::find($id);
        $offer->status = 'accepted';
        $offer->save();

        $message = new Message();
        $message->user_id      = $this->user->id;
        $message->to_user       = $toUser;
        $message->listing_id    = $offer->listing_id;
        $message->message       = '<p>Congratulations! Your Offer is accepted.</p>';
		$message->message_seen  = 'no';
        $message->save();

        return Reply::success('You have successfully accepted offer');
    }

    public function declineOffer($id, $toUser, $messageId)
    {
        $message = Message::findOrFail($messageId);
        $newMessage = explode('<div class="col-12 margin-top-20">', $message->message);
        $newMessage = $newMessage[0].'</p>';
        $message->message = $newMessage;
        $message->save();
        $offer = Offer::find($id);
        $offer->status = 'rejected';
        $offer->save();

        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $toUser;
        $message->listing_id    = $offer->listing_id;
        $message->message       = '<p>Your Offer declined.</p>';
		$message->message_seen  = 'no';
        $message->save();

        return Reply::success('Offer Decline Successfully');
    }

    public function acceptDispute($id){
        $dispute = Dispute::findOrFail($id);
        if ($dispute->status == 'pending' && $dispute->user_id != $this->user->id){
            $dispute->status = 'accepted';
            $dispute->save();
            $listing = Listing::find($dispute->listing_id);
            $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Cancellation request approved <span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                                <div class="col-12 message-cancellation"><strong>Request Timer:</strong> 22h 28m <i class="icon-feather-info" title="If client is unresponsive in this time funds will be refunded" data-tippy-placement="top"></i></div>
								<div class="col-12 message-cancellation"><strong>Reason:</strong>'.$dispute->reason.'</div>
								<div class="col-12 message-cancellation margin-bottom-20"><strong>Reason:</strong> '.$dispute->description.'</div>
                            </p>';
            $message = new Message();
            $message->user_id       = $this->user->id;
            $message->to_user       = $dispute->user_id;
            $message->listing_id    = $listing->id;
            $message->message       = $this->message;
			$message->message_seen  = 'no';
            $message->save();
            return Reply::success('Dispute Accepted');
        }
    }

    public function declineDispute($id){
        $dispute = Dispute::findOrFail($id);
        if ($dispute->status == 'pending' && $dispute->user_id != $this->user->id){
            $dispute->status = 'rejected';
            $dispute->save();
            $listing = Listing::find($dispute->listing_id);
            $this->message = '<p class="row">
                                <div class="col-12 message-cancellation margin-bottom-10">Cancellation request was not approved <span class="pull-right">'.Carbon::now()->format('h:i a m/d/Y').'</span></div>
                                <div class="col-12 message-cancellation"><strong>Job Title:</strong> <a href="'. route('listing.list.show', $listing->id) .'">'. $listing->job_title .'</a></div>
                                <div class="col-12 message-cancellation"><strong>Request Timer:</strong> 22h 28m <i class="icon-feather-info" title="If client is unresponsive in this time funds will be refunded" data-tippy-placement="top"></i></div>
								<div class="col-12 message-cancellation"><strong>Reason:</strong>'.$dispute->reason.'</div>
								<div class="col-12 message-cancellation margin-bottom-20"><strong>Reason:</strong> '.$dispute->description.'</div>
                            </p>';
            $message = new Message();
            $message->user_id       = $this->user->id;
            $message->to_user       = $dispute->user_id;
            $message->listing_id    = $listing->id;
            $message->message       = $this->message;
			$message->message_seen  = 'no';
            $message->save();
            return Reply::success('Dispute Rejected');
        }
    }

    public function messagePopup($toUserId, $listingId){
        $toUser = user::where('id', $toUserId)->first();
        $this->toUserName = $toUser->first_name. ' ' . $toUser->last_name;
        $this->toUserId = $toUserId;
        $this->listingId = $listingId;
        $view = view('user/message/messages-popup', $this->data)->render();
        return Reply::dataOnly(['view' => $view]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

    }

    public function store(Request $request)
    {
        $message = new Message();
        $message->user_id       = $this->user->id;
        $message->to_user       = $request->to_user;
        $message->listing_id    = $request->listing_id;
        $message->message       = $request->message;
		$message->message_seen  = 'no';
        $message->save();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

    }

    public function update(CreateRequest $request, $id){

    }

    public function destroy($id)
    {
        $from = $id;
        $to = $this->user->id;
        Message::with('fromuser')
            ->where(function($query) use ($from, $to){
                $query->where('user_id', $from)
                    ->where('to_user', $to)
                    ->orWhere(function($q) use ($from, $to) {
                        $q->where('to_user', $from)
                            ->where('user_id', $to);
                    });
            })
            ->delete();
//        Message::where('user_id', $id)->orWhere('to_user', $this->user->id)->delete();
        return Reply::success('Messages deleted successfully');
    }

    public function updateStatus($status){
//        dd($status);
        $this->user->status = $status;
        $this->user->save();
    }
}
