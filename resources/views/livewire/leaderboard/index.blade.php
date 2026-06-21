<div class="max-w-3xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-6">Ranking</flux:heading>

    <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700 mb-4">
        <button wire:click="$set('tab', 'characters')"
                class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition
                       {{ $tab === 'characters' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Postacie (XP)
        </button>
        <button wire:click="$set('tab', 'players')"
                class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition
                       {{ $tab === 'players' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Gracze
        </button>
    </div>

    @if ($tab === 'characters')
        @if ($this->characters->isEmpty())
            <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
                <flux:icon name="trophy" class="w-12 h-12 mx-auto mb-3 opacity-40" />
                <flux:text>Brak postaci w rankingu.</flux:text>
            </div>
        @else
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                @foreach ($this->characters as $i => $character)
                    <div class="flex items-center gap-4 px-4 py-3">
                        <div class="shrink-0 w-8 text-center font-bold text-lg
                            {{ $i === 0 ? 'text-amber-500' : ($i === 1 ? 'text-zinc-400' : ($i === 2 ? 'text-orange-600' : 'text-zinc-400')) }}">
                            @if ($i < 3)
                                <flux:icon name="trophy" class="w-5 h-5 mx-auto" />
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <flux:avatar :name="$character->name" :src="$character->avatar ?: null" class="shrink-0" />
                        <div class="flex-1 min-w-0">
                            <flux:heading size="sm" class="truncate">{{ $character->name }}</flux:heading>
                            <flux:text class="text-xs text-zinc-400">
                                {{ $character->race ?: '—' }} · gracz: {{ $character->user?->name ?? '—' }}
                            </flux:text>
                        </div>
                        <div class="shrink-0 flex items-center gap-4 text-sm">
                            <div class="text-center">
                                <div class="font-semibold">{{ $character->experience }}</div>
                                <div class="text-xs text-zinc-400">XP</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold">{{ $character->history_points }}</div>
                                <div class="text-xs text-zinc-400">PH</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        @if ($this->ranking->isEmpty())
            <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
                <flux:icon name="trophy" class="w-12 h-12 mx-auto mb-3 opacity-40" />
                <flux:text>Brak danych do rankingu.</flux:text>
            </div>
        @else
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                @foreach ($this->ranking as $i => $user)
                    <div class="flex items-center gap-4 px-4 py-3 {{ $user->id === auth()->id() ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="shrink-0 w-8 text-center font-bold text-lg
                            {{ $i === 0 ? 'text-amber-500' : ($i === 1 ? 'text-zinc-400' : ($i === 2 ? 'text-orange-600' : 'text-zinc-400')) }}">
                            @if ($i < 3)
                                <flux:icon name="trophy" class="w-5 h-5 mx-auto" />
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <div class="relative shrink-0">
                            <flux:avatar :name="$user->name" />
                            <span class="absolute -bottom-0.5 -right-0.5 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-zinc-900
                                {{ $user->isOnline() ? 'bg-green-500' : 'bg-zinc-400' }}"
                                title="{{ $user->isOnline() ? 'Online' : 'Offline' }}"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:heading size="sm" class="truncate">
                                <a href="{{ route('player.show', $user->id) }}" wire:navigate class="hover:underline">{{ $user->name }}</a>
                                @if ($user->id === auth()->id())
                                    <span class="text-xs text-blue-500">(Ty)</span>
                                @endif
                            </flux:heading>
                            <flux:text class="text-xs text-zinc-400">{{ $user->getRoleLabel() }}</flux:text>
                        </div>
                        <div class="shrink-0 flex items-center gap-4 text-sm">
                            <div class="text-center">
                                <div class="font-semibold">{{ $user->posts_count }}</div>
                                <div class="text-xs text-zinc-400">postów</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold">{{ $user->badges_count }}</div>
                                <div class="text-xs text-zinc-400">odznak</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
