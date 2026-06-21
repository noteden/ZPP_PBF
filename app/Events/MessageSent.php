<?php

namespace App\Events;

use App\Models\PrivateMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Nadawane natychmiast po wysłaniu prywatnej wiadomości (real-time czat). */
class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** Posortowana para id [min, max] tworząca nazwę kanału konwersacji. */
    public array $ids;
    public int $messageId;

    public function __construct(PrivateMessage $message)
    {
        $ids = [(int) $message->sender_user_id, (int) $message->receiver_user_id];
        sort($ids);

        $this->ids = $ids;
        $this->messageId = (int) $message->id;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('conversation.'.$this->ids[0].'.'.$this->ids[1])];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}
