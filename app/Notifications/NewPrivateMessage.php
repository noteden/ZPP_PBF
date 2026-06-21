<?php

namespace App\Notifications;

use App\Models\PrivateMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPrivateMessage extends Notification
{
    use Queueable;

    public function __construct(public PrivateMessage $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'sender'     => $this->message->senderUser?->name ?? 'Nieznany',
            'message_id' => $this->message->id,
            'preview'    => mb_substr($this->message->content, 0, 100),
        ];
    }
}
