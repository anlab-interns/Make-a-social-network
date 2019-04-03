<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptFriend extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param $id
     */
    public function __construct(User $user, $uid)
    {
        $this->user = $user;
        $this->uid = $uid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @param $uid
     * @param $name
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->user->name . ' already accept your friend request',
            'creater_id' => $this->user->id,
            'receiver_id' => $this->uid,
        ];
    }
}
