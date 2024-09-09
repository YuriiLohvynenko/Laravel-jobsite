<?php

namespace App\Notifications;

use App\Models\UserBadge;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BadgeVerification extends Notification
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
        if($this->badge->documentUrl()) {
            return (new MailMessage)
                ->subject('Badge Verification!')
                ->greeting('Hello Admin!')
                ->line($this->user->full_name.' submitted his documents for badge verification')
                ->line('First Name:- '.$this->user->first_name)
                ->line('Last Name:- '.$this->user->last_name)
                ->line('Email:- '.$this->user->email)
                ->line('Document Name:- '.$this->badge->document_type)
                ->action('View Document', $this->badge->documentUrl())
                ->line('Thank you for using our application!');
        }
        else {
            return (new MailMessage)
                ->subject('Badge Verification!')
                ->greeting('Hello Admin!')
                ->line($this->user->full_name.' submitted his documents for badge verification')
                ->line('First Name:- '.$this->user->first_name)
                ->line('Last Name:- '.$this->user->last_name)
                ->line('Email:- '.$this->user->email)
                ->line('Job Title:- '.$this->badge->job_title)
                ->line('Background Check Package:- '.$this->badge->package_check)
                ->line('Thank you for using our application!');
        }

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
