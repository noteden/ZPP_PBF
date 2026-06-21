<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('forum.index') }}" wire:navigate class="hover:underline">Forum</a>
        <span class="mx-1">›</span>
        <span>{{ $forum->category->name }}</span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl">{{ $forum->name }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ $forum->description }}</flux:text>
        </div>
        <flux:button :href="route('forum.thread.create', $forum->id)" wire:navigate variant="primary" icon="plus">
            Nowy wątek
        </flux:button>
    </div>

    <div class="mb-6 flex items-center gap-3">
        <flux:input wire:model.live.debounce.400ms="search" icon="magnifying-glass"
                    placeholder="Szukaj w wątkach i postach..." class="flex-1" />
        <flux:checkbox wire:model.live="showArchived" label="Pokaż zarchiwizowane" />
    </div>

    @if ($this->threads->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="chat-bubble-bottom-center-text" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>
                @if ($search !== '')
                    Brak wyników dla „{{ $search }}".
                @else
                    Brak wątków. Zacznij dyskusję!
                @endif
            </flux:text>
        </div>
    @else
        <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @foreach ($this->threads as $thread)
                <a href="{{ route('forum.thread.show', $thread->id) }}" wire:navigate
                   class="flex items-center gap-4 px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                    <flux:icon name="chat-bubble-left" class="w-6 h-6 text-zinc-400 shrink-0" />
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <flux:heading size="sm" class="truncate">{{ $thread->name }}</flux:heading>
                            @if ($thread->tag)
                                <flux:badge :color="$thread->tag->color()" size="sm">{{ $thread->tag->label() }}</flux:badge>
                            @endif
                            @if ($thread->archived)
                                <flux:badge color="zinc" size="sm" icon="archive-box">Archiwum</flux:badge>
                            @endif
                        </div>
                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $thread->user?->name ?? 'Nieznany' }} ·
                            {{ $thread->created_at->diffForHumans() }}
                        </flux:text>
                    </div>
                    <div class="shrink-0 text-xs text-zinc-400">
                        {{ $thread->posts_count }} {{ \App\Support\Plural::pl($thread->posts_count, 'post', 'posty', 'postów') }}
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $this->threads->links() }}
        </div>
    @endif
</div>
