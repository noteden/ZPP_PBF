<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/** Liczniki nieprzeczytanych wiadomości i powiadomień w menu — aktualizowane na żywo. */
class Counters extends Component
{
    public function getListeners(): array
    {
        // Nowa wiadomość prywatna też tworzy powiadomienie (NotificationReceived),
        // więc ten jeden kanał odświeża oba liczniki.
        return [
            'echo-private:App.Models.User.'.Auth::id().',.NotificationReceived' => 'onNotification',
        ];
    }

    public function onNotification(): void
    {
        unset($this->unreadMessages, $this->unreadNotifications);
    }

    #[Computed]
    public function unreadMessages(): int
    {
        return Auth::user()->receivedMessages()->where('is_read', false)->count();
    }

    #[Computed]
    public function unreadNotifications(): int
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.notifications.counters');
    }
}
