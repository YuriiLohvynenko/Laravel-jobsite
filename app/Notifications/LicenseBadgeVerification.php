<?php

namespace App\Notifications;

use App\Models\UserBadge;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LicenseBadgeVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $user;
    private $badge;
    public function __construct(User $user, UserBadge $userBadge)
    {
        $this->user = $user;
        $this->badge = $userBadge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Badge Verification!')
            ->greeting('Hello Admin!')
            ->line($this->user->full_name.' submitted his documents for badge verification')
            ->line('Badge Name:- '.$this->badge->badge->name)
            ->line('Name:- '.$this->badge->name)
            ->line('License #:- '.$this->badge->license_no)
            ->line('Description #:- '.(!is_null($this->badge->description) ? $this->badge->description : '-'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
