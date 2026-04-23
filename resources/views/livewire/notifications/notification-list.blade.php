<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Powiadomienia</flux:heading>
        @if ($this->unreadCount > 0)
            <flux:button wire:click="markAllRead" variant="ghost" size="sm">
                Oznacz wszystkie jako przeczytane
            </flux:button>
        @endif
    </div>

    @if ($this->notifications->isEmpty())
        <div class="text-center py-16 text-zinc-400">
            <flux:icon name="bell" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Nie masz żadnych powiadomień.</flux:text>
        </div>
    @else
        <div class="flex flex-col gap-2">
            @foreach ($this->notifications as $notification)
                <div class="flex items-start gap-3 rounded-xl border px-4 py-3
                    {{ $notification->read_at ? 'border-zinc-200 dark:border-zinc-700' : 'border-blue-300 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20' }}">

                    <flux:icon name="bell" class="w-4 h-4 mt-0.5 shrink-0 text-zinc-400" />

                    <div class="flex-1 min-w-0">
                        @if (isset($notification->data['sender']))
                            <flux:text class="text-sm font-medium">
                                Nowa wiadomość od {{ $notification->data['sender'] }}
                            </flux:text>
                            <flux:text class="text-xs text-zinc-400 truncate">
                                {{ $notification->data['preview'] ?? '' }}
                            </flux:text>
                        @elseif (isset($notification->data['author']))
                            <flux:text class="text-sm font-medium">
                                {{ $notification->data['author'] }} odpowiedział w wątku
                            </flux:text>
                            <flux:text class="text-xs text-zinc-400 truncate">
                                {{ $notification->data['preview'] ?? '' }}
                            </flux:text>
                        @else
                            <flux:text class="text-sm">Nowe powiadomienie</flux:text>
                        @endif
                        <flux:text class="text-xs text-zinc-400 mt-0.5">
                            {{ $notification->created_at->diffForHumans() }}
                        </flux:text>
                    </div>

                    <div class="flex gap-1 shrink-0">
                        @if (!$notification->read_at)
                            <flux:button wire:click="markRead('{{ $notification->id }}')" variant="ghost" size="sm" icon="check" />
                        @endif
                        <flux:button wire:click="delete('{{ $notification->id }}')" variant="ghost" size="sm" icon="trash" />
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
