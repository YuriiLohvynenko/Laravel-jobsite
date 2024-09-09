<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\Thread;

class MessageObserver
{
    public function saving(Message $message) {
//        dd(request()->oldThread);
        if (!request()->oldThread)
        {
            $thread = Thread::where(function($query) use ($message){
                $query->where('user_id', $message->user_id)
                    ->where('to_user', $message->to_user)
                    ->orWhere(function($q) use ($message) {
                        $q->where('to_user', $message->user_id)
                            ->where('user_id', $message->to_user);
                    });
            })
                ->first();
            if ($thread){
                $message->threads_id = $thread->id;
            }
            else{
                $thread = new Thread();
                $thread->user_id = $message->user_id;
                $thread->to_user = $message->to_user;
                $thread->save();
                $message->threads_id = $thread->id;
                $message->save();
            }
        }
        else{
            $message->threads_id = request()->oldThread;
        }
    }
}
