<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $follower;

    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->follower->name} sizni kuzatishni boshladi.")
            ->action('Profilini ko‘rish', url("/profiles/{$this->follower->username}"))
            ->line('Yangi kuzatuvchingiz bilan salomlashing!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'message' => "{$this->follower->name} sizni kuzatishni boshladi."
        ];
    }
}
?>