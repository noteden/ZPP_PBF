<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Forum</flux:heading>
    </div>

    @if ($this->categories->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="chat-bubble-left-right" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Brak kategorii forum.</flux:text>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($this->categories as $category)
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="px-4 py-3 bg-zinc-100 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <div>
                            <flux:heading size="lg">{{ $category->name }}</flux:heading>
                            @if ($category->description)
                                <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ $category->description }}</flux:text>
                            @endif
                        </div>
                        @if ($category->OnlyforGM)
                            <flux:badge color="purple" size="sm">MG only</flux:badge>
                        @endif
                    </div>

                    @if ($category->forums->isEmpty())
                        <div class="px-4 py-6 text-sm text-zinc-400">Brak forów w tej kategorii.</div>
                    @else
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach ($category->forums as $forum)
                                <a href="{{ route('forum.show', $forum->id) }}" wire:navigate
                                   class="flex items-center gap-4 px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                                    <flux:icon name="folder" class="w-6 h-6 text-zinc-400 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <flux:heading size="sm" class="truncate">{{ $forum->name }}</flux:heading>
                                        <flux:text class="truncate text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $forum->description }}
                                        </flux:text>
                                    </div>
                                    <div class="shrink-0 text-xs text-zinc-400">
                                        {{ $forum->threads_count }} {{ \App\Support\Plural::pl($forum->threads_count, 'wątek', 'wątki', 'wątków') }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
