<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('forum.index') }}" wire:navigate class="hover:underline">Forum</a>
        <span class="mx-1">›</span>
        <a href="{{ route('forum.show', $thread->forum->id) }}" wire:navigate class="hover:underline">{{ $thread->forum->name }}</a>
        <span class="mx-1">›</span>
        <span>{{ $thread->name }}</span>
    </div>

    <div class="flex items-center gap-3 mb-6">
        <flux:heading size="xl">{{ $thread->name }}</flux:heading>
        @if ($thread->tag)
            <flux:badge :color="$thread->tag->color()" size="sm">{{ $thread->tag->label() }}</flux:badge>
        @endif
        @if ($thread->archived)
            <flux:badge color="zinc" size="sm" icon="archive-box">Archiwum</flux:badge>
        @endif
        @if (auth()->user()?->isModerator())
            <flux:spacer />
            <flux:button size="sm" variant="ghost"
                         :icon="$thread->archived ? 'archive-box-x-mark' : 'archive-box'"
                         wire:click="toggleArchive">
                {{ $thread->archived ? 'Przywróć' : 'Archiwizuj' }}
            </flux:button>
        @endif
    </div>

    @if ($thread->archived)
        <div class="mb-6 rounded-lg bg-zinc-100 dark:bg-zinc-800 px-4 py-2 text-sm text-zinc-500">
            Ten wątek jest zarchiwizowany.
        </div>
    @endif

    <div class="space-y-4 mb-8">
        @foreach ($this->posts as $post)
            <div id="post-{{ $post->id }}"
                 class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden bg-white dark:bg-zinc-900">
                <div class="flex items-center justify-between px-4 py-2 bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3 min-w-0">
                        <flux:avatar :name="$post->charakter?->name ?? $post->user?->name ?? '?'" size="sm" class="shrink-0" />
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <flux:heading size="sm" class="truncate">
                                    {{ $post->charakter?->name ?? $post->user?->name ?? 'Nieznany' }}
                                </flux:heading>
                                @if ($post->charakter)
                                    <flux:badge color="zinc" size="sm">postać</flux:badge>
                                @endif
                                @if ($post->tag && $post->tag !== \App\Enums\PostTag::Normal)
                                    <flux:badge :color="$post->tag->color()" size="sm">{{ $post->tag->label() }}</flux:badge>
                                @endif
                            </div>
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $post->charakter ? '(gracz: '.$post->user?->name.') · ' : '' }}
                                {{ $post->created_at->diffForHumans() }}
                            </flux:text>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <flux:button size="xs" variant="ghost" icon="chat-bubble-left-ellipsis"
                                     wire:click="quote({{ $post->id }})">Cytuj</flux:button>
                    </div>
                </div>
                <div class="px-4 py-3 space-y-3">
                    @foreach ($post->quotedPosts as $quoted)
                        <div class="rounded-lg border-l-4 border-blue-400 bg-zinc-50 dark:bg-zinc-800/50 px-3 py-2">
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                <strong>{{ $quoted->charakter?->name ?? $quoted->user?->name ?? 'Nieznany' }}</strong> napisał(a):
                            </div>
                            <div class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                {{ Str::limit($quoted->content, 240) }}
                            </div>
                        </div>
                    @endforeach

                    @if ($post->tag === \App\Enums\PostTag::Spoiler)
                        <details class="rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 px-3 py-2">
                            <summary class="cursor-pointer text-sm font-medium text-yellow-700 dark:text-yellow-200">Spoiler — kliknij aby pokazać</summary>
                            <div class="mt-2 whitespace-pre-wrap text-sm">{{ $post->content }}</div>
                        </details>
                    @else
                        <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $post->content }}</div>
                    @endif
                </div>
                <div class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                    <livewire:reports.report-post :post="$post" :key="'report-'.$post->id" />
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 mb-8">{{ $this->posts->links() }}</div>

    {{-- Reply form --}}
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 bg-white dark:bg-zinc-900"
         x-data x-on:focus-reply.window="$nextTick(() => $refs.replyBox?.focus())">
        <flux:heading size="md" class="mb-3">Odpowiedz</flux:heading>

        @if ($quotedPostId)
            <div class="mb-3 flex items-center justify-between rounded-lg bg-blue-50 dark:bg-blue-900/30 px-3 py-2 text-sm">
                <span>Cytujesz post #{{ $quotedPostId }}</span>
                <flux:button size="xs" variant="ghost" wire:click="clearQuote">Anuluj cytat</flux:button>
            </div>
        @endif

        <form wire:submit="reply" class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tag</label>
                    <select wire:model="tag"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm">
                        @foreach (\App\Enums\PostTag::cases() as $t)
                            <option value="{{ $t->value }}">{{ $t->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Postać (opcjonalnie)</label>
                    <select wire:model="charakter_id"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm">
                        <option value="">— Piszę jako ja (poza grą) —</option>
                        @foreach ($this->characters as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <flux:textarea wire:model="content" rows="5" placeholder="Twoja odpowiedź..." x-ref="replyBox" />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane">Wyślij</flux:button>
            </div>
        </form>
    </div>
</div>
