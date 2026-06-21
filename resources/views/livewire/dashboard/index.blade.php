<div class="flex h-full w-full flex-1 flex-col gap-6 p-4">
    @php $user = auth()->user(); @endphp

    {{-- Powitanie --}}
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-zinc-50 to-white dark:from-zinc-900 dark:to-zinc-800 p-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-4">
                <flux:avatar :name="$user->name" size="lg" />
                <div>
                    <flux:heading size="xl">Witaj, {{ $user->name }}!</flux:heading>
                    <div class="flex items-center gap-2 mt-1">
                        <flux:badge :color="$user->role->color()" size="sm">{{ $user->getRoleLabel() }}</flux:badge>
                        <flux:text class="text-sm text-zinc-500">Aktualizacje na żywo aktywne.</flux:text>
                    </div>
                </div>
            </div>
            <flux:button :href="route('forum.index')" wire:navigate variant="primary" icon="chat-bubble-left-right">
                Przejdź do forum
            </flux:button>
        </div>
    </div>

    {{-- Statystyki --}}
    <div class="grid auto-rows-min gap-4 grid-cols-2 lg:grid-cols-4">
        @foreach ($this->stats as $stat)
            <a href="{{ $stat['route'] }}" wire:navigate
               class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 hover:border-zinc-300 dark:hover:border-zinc-600 transition flex items-center gap-3">
                <div class="rounded-lg bg-zinc-100 dark:bg-zinc-800 p-2.5">
                    <flux:icon :name="$stat['icon']" class="w-6 h-6 text-zinc-500 dark:text-zinc-300" />
                </div>
                <div>
                    <div class="text-2xl font-bold">{{ $stat['value'] }}</div>
                    <div class="text-xs text-zinc-400">{{ $stat['label'] }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Ostatnia aktywność --}}
        <div class="lg:col-span-2 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Ostatnia aktywność</flux:heading>
                <flux:button :href="route('forum.index')" wire:navigate size="sm" variant="ghost">Wszystkie</flux:button>
            </div>

            @if ($this->recentPosts->isEmpty())
                <flux:text class="text-sm text-zinc-400">Brak postów. Rozpocznij pierwszą historię!</flux:text>
            @else
                <div class="space-y-3">
                    @foreach ($this->recentPosts as $post)
                        <a href="{{ route('forum.thread.show', $post->thread_id) }}#post-{{ $post->id }}" wire:navigate
                           class="flex items-start gap-3 rounded-lg border border-zinc-100 dark:border-zinc-800 p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <flux:avatar :name="$post->charakter?->name ?? $post->user?->name ?? '?'"
                                         :src="$post->charakter?->avatar ?: null" size="sm" class="shrink-0" />
                            <div class="min-w-0 flex-1">
                                <div class="text-sm">
                                    <strong>{{ $post->charakter?->name ?? $post->user?->name ?? 'Nieznany' }}</strong>
                                    <span class="text-zinc-400">w</span>
                                    <span class="text-zinc-600 dark:text-zinc-300">{{ $post->thread?->name ?? 'wątku' }}</span>
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1">{{ \Illuminate\Support\Str::limit($post->content, 120) }}</div>
                                <div class="text-xs text-zinc-400 mt-0.5">{{ $post->created_at?->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Boczna kolumna --}}
        <div class="space-y-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <flux:heading size="lg" class="mb-3">Popularne wątki</flux:heading>
                @if ($this->trending->isEmpty())
                    <flux:text class="text-sm text-zinc-400">Brak wątków.</flux:text>
                @else
                    <div class="space-y-2">
                        @foreach ($this->trending as $thread)
                            <a href="{{ route('forum.thread.show', $thread->id) }}" wire:navigate
                               class="flex items-center justify-between gap-2 rounded-lg px-2 py-1.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <span class="text-sm truncate">{{ $thread->name }}</span>
                                <flux:badge color="zinc" size="sm">{{ $thread->posts_count }}</flux:badge>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="flex items-center justify-between mb-3">
                    <flux:heading size="lg">Wydarzenia</flux:heading>
                    <flux:button :href="route('events.index')" wire:navigate size="sm" variant="ghost">Kalendarz</flux:button>
                </div>
                @if ($this->upcomingEvents->isEmpty())
                    <flux:text class="text-sm text-zinc-400">Brak zaplanowanych wydarzeń.</flux:text>
                @else
                    <div class="space-y-2">
                        @foreach ($this->upcomingEvents as $event)
                            <div class="flex items-center gap-3">
                                <div class="shrink-0 text-center rounded-lg bg-zinc-100 dark:bg-zinc-800 px-2 py-1">
                                    <div class="text-sm font-bold leading-none">{{ $event->date?->format('d') }}</div>
                                    <div class="text-[10px] uppercase text-zinc-400">{{ $event->date?->format('M') }}</div>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm truncate">{{ $event->name }}</div>
                                    <div class="text-xs text-zinc-400">{{ $event->date?->format('H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Moje postacie + szybkie akcje --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Moje postacie</flux:heading>
                <flux:button :href="route('character.create')" wire:navigate size="sm" variant="ghost" icon="plus">Nowa</flux:button>
            </div>
            @if ($this->myCharacters->isEmpty())
                <flux:text class="text-sm text-zinc-400">Nie masz jeszcze postaci. Stwórz pierwszą!</flux:text>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach ($this->myCharacters as $character)
                        <a href="{{ route('character.show', $character->id) }}" wire:navigate
                           class="flex items-center gap-3 rounded-lg border border-zinc-100 dark:border-zinc-800 p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <flux:avatar :name="$character->name" :src="$character->avatar ?: null" size="sm" />
                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate">{{ $character->name }}</div>
                                <div class="text-xs text-zinc-400">{{ $character->experience }} XP</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <flux:heading size="lg" class="mb-3">Szybkie akcje</flux:heading>
            <div class="grid grid-cols-2 gap-2">
                <flux:button :href="route('character.create')" wire:navigate size="sm" variant="ghost" icon="plus" class="justify-start">Postać</flux:button>
                <flux:button :href="route('missions.index')" wire:navigate size="sm" variant="ghost" icon="map" class="justify-start">Misje</flux:button>
                <flux:button :href="route('world-logs.index')" wire:navigate size="sm" variant="ghost" icon="book-open" class="justify-start">Kronika</flux:button>
                <flux:button :href="route('leaderboard.index')" wire:navigate size="sm" variant="ghost" icon="trophy" class="justify-start">Ranking</flux:button>
                <flux:button :href="route('library.index')" wire:navigate size="sm" variant="ghost" icon="book-open" class="justify-start">Biblioteka</flux:button>
                <flux:button :href="route('messages.index')" wire:navigate size="sm" variant="ghost" icon="envelope" class="justify-start">Wiadomości</flux:button>
            </div>
        </div>
    </div>
</div>
