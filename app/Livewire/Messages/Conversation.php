<?php

namespace App\Livewire\Messages;

use App\Events\MessageSent;
use App\Models\PrivateMessage;
use App\Models\User;
use App\Notifications\NewPrivateMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Konwersacja')]
class Conversation extends Component
{
    public int $partnerId;

    /** Nasłuch real-time: nowa wiadomość w tej konwersacji. */
    public function getListeners(): array
    {
        $ids = [(int) Auth::id(), $this->partnerId];
        sort($ids);

        return [
            "echo-private:conversation.{$ids[0]}.{$ids[1]},.MessageSent" => 'onMessageReceived',
        ];
    }

    public function onMessageReceived(): void
    {
        // Oznacz nowe wiadomości od rozmówcy jako przeczytane i odśwież listę.
        PrivateMessage::where('sender_user_id', $this->partnerId)
            ->where('receiver_user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        unset($this->messages);
        $this->dispatch('message-sent');
    }

    public function mount(User $partner): void
    {
        $this->partnerId = $partner->id;

        PrivateMessage::where('sender_user_id', $partner->id)
            ->where('receiver_user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    #[Computed]
    public function partner(): User
    {
        return User::findOrFail($this->partnerId);
    }

    #[Computed]
    public function messages(): Collection
    {
        $userId    = Auth::id();
        $partnerId = $this->partnerId;

        return PrivateMessage::where(function ($q) use ($userId, $partnerId) {
            $q->where('sender_user_id', $userId)
              ->where('receiver_user_id', $partnerId);
        })->orWhere(function ($q) use ($userId, $partnerId) {
            $q->where('sender_user_id', $partnerId)
              ->where('receiver_user_id', $userId);
        })
        ->with('senderUser')
        ->orderBy('created_at')
        ->get();
    }

    public function sendMessage(string $msgContent = ''): void
    {
        if ($this->partnerId == Auth::id()) {
            return;
        }

        Validator::make(
            ['content' => $msgContent],
            ['content' => 'required|string|max:5000'],
            ['content.required' => 'Treść wiadomości nie może być pusta.',
             'content.max'      => 'Wiadomość nie może przekraczać 5000 znaków.']
        )->validate();

        $message = PrivateMessage::create([
            'sender_user_id'   => Auth::id(),
            'receiver_user_id' => $this->partnerId,
            'content'          => $msgContent,
            'is_read'          => false,
        ]);

        $message->load('senderUser');
        $this->partner->notify(new NewPrivateMessage($message));

        // Real-time: nadaj wiadomość na prywatny kanał konwersacji.
        MessageSent::dispatch($message);

        unset($this->messages);
        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.messages.conversation', [
            'partner' => $this->partner,
        ])->layout('layouts.app');
    }
}
