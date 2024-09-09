<?php

namespace App\Http\Controllers\User;

use App\Classes\Reply;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class NotificationController extends BaseController
{
    public function markAsRead($notification_id)
    {echo $notification_id; die();
        if ($notification_id == 'all') {
            $this->user->unreadNotifications->markAsRead();
            $message = 'Marked all as read';
        }
        else {
            $this->user->unreadNotifications->where('id', $notification_id)->markAsRead();
            $message = 'Notification marked as read successfully';
        }

        $view = view('common.notifications', ['unreadNotifications' => $this->user->notifications()->whereNull('read_at')->get()])->render();

        return Reply::success( $message, ['view' => $view]);
		// return Reply::success($message);
    }
}
