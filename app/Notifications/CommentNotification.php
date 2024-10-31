<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class CommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $commenter;

    public function __construct(Post $post, $commenter)
    {
        $this->post = $post;
        $this->commenter = $commenter;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->commenter->name} sizning postingizga izoh qoldirdi.")
            ->action('Postni ko‘rish', url("/posts/{$this->post->id}"))
            ->line('Yangi izohni o‘qing va fikr bildiring!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->name,
            'message' => "{$this->commenter->name} sizning postingizga izoh qoldirdi."
        ];
    }
}
?>