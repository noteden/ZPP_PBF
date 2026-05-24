<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Powiadomienia')]
class NotificationList extends Component
{
    public function markAllRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        unset($this->notifications);
    }

    public function markRead(string $id): void
    {
        Auth::user()->notifications()->findOrFail($id)->markAsRead();
        unset($this->notifications);
    }

    public function delete(string $id): void
    {
        Auth::user()->notifications()->findOrFail($id)->delete();
        unset($this->notifications);
    }

    #[Computed]
    public function notifications(): Collection
    {
        return Auth::user()->notifications()->latest()->get();
    }

    #[Computed]
    public function unreadCount(): int
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.notifications.notification-list')
            ->layout('layouts.app');
    }
}
