<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Nadawane natychmiast po utworzeniu posta w wątku (real-time forum). */
class PostCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $threadId;
    public int $postId;

    public function __construct(Post $post)
    {
        $this->threadId = (int) $post->thread_id;
        $this->postId = (int) $post->id;
    }

    public function broadcastOn(): array
    {
        return [new Channel('thread.'.$this->threadId)];
    }

    public function broadcastAs(): string
    {
        return 'PostCreated';
    }
}
