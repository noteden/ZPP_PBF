<div class="contents">
    <flux:sidebar.item icon="envelope" :href="route('messages.index')" :current="request()->routeIs('messages.*')" wire:navigate>
        Wiadomości
        @if ($this->unreadMessages > 0)
            <flux:badge color="blue" size="sm" class="ms-auto">{{ $this->unreadMessages }}</flux:badge>
        @endif
    </flux:sidebar.item>

    <flux:sidebar.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')" wire:navigate>
        Powiadomienia
        @if ($this->unreadNotifications > 0)
            <flux:badge color="red" size="sm" class="ms-auto">{{ $this->unreadNotifications }}</flux:badge>
        @endif
    </flux:sidebar.item>
</div>
