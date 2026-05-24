<?php

namespace App\Livewire\Messages;

use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Wiadomości')]
class Inbox extends Component
{
    public bool $showNewMessageModal = false;
    public ?int $selectedUserId = null;
    public string $newMessageContent = '';

    #[Computed]
    public function conversations(): Collection
    {
        $userId = Auth::id();

        return PrivateMessage::where('sender_user_id', $userId)
            ->orWhere('receiver_user_id', $userId)
            ->with(['senderUser', 'receiverUser'])
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn ($msg) => $msg->sender_user_id === $userId
                ? $msg->receiver_user_id
                : $msg->sender_user_id
            )
            ->map(function (Collection $messages, int $partnerId) use ($userId) {
                $last    = $messages->first();
                $partner = $last->sender_user_id === $userId
                    ? $last->receiverUser
                    : $last->senderUser;

                return (object) [
                    'partner'      => $partner,
                    'last_message' => $last,
                    'unread'       => $messages
                        ->where('receiver_user_id', $userId)
                        ->where('is_read', false)
                        ->count(),
                ];
            });
    }

    #[Computed]
    public function availableUsers(): Collection
    {
        return User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function openNewMessage(): void
    {
        $this->showNewMessageModal = true;
    }

    public function sendNewMessage(): void
    {
        $this->validate([
            'selectedUserId'    => 'required|exists:users,id',
            'newMessageContent' => 'required|string|max:5000',
        ]);

        $recipientId = $this->selectedUserId;

        PrivateMessage::create([
            'sender_user_id'   => Auth::id(),
            'receiver_user_id' => $recipientId,
            'content'          => $this->newMessageContent,
            'is_read'          => false,
        ]);

        $this->showNewMessageModal = false;
        $this->selectedUserId     = null;
        $this->newMessageContent  = '';

        $this->redirect(route('messages.conversation', $recipientId), navigate: true);
    }

    public function render()
    {
        return view('livewire.messages.inbox')
            ->layout('layouts.app');
    }
}
