<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewThreadReply extends Notification
{
    use Queueable;

    public function __construct(public Post $post) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'author'    => $this->post->user->name,
            'thread_id' => $this->post->thread_id,
            'post_id'   => $this->post->id,
            'preview'   => mb_substr($this->post->content, 0, 100),
        ];
    }
}
