<div class="max-w-4xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-6">Biblioteka</flux:heading>

    <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700 mb-4">
        <button wire:click="$set('tab', 'documents')"
                class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition
                       {{ $tab === 'documents' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Dokumenty ({{ $this->documents->count() }})
        </button>
        <button wire:click="$set('tab', 'tutorials')"
                class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition
                       {{ $tab === 'tutorials' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Tutoriale ({{ $this->tutorials->count() }})
        </button>
    </div>

    @if ($tab === 'documents')
        @if ($this->documents->isEmpty())
            <div class="text-center py-16 text-zinc-400">
                <flux:icon name="document-text" class="w-12 h-12 mx-auto mb-3 opacity-40" />
                <flux:text>Brak dokumentów.</flux:text>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($this->documents as $doc)
                    <details class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <summary class="cursor-pointer px-4 py-3 bg-zinc-50 dark:bg-zinc-900 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <flux:heading size="md">{{ $doc->name }}</flux:heading>
                                @if ($doc->category)
                                    <flux:badge color="zinc" size="sm">{{ ucfirst($doc->category) }}</flux:badge>
                                @endif
                            </div>
                            <flux:text class="text-xs text-zinc-400">
                                {{ $doc->created_at?->format('Y-m-d') }}
                            </flux:text>
                        </summary>
                        <div class="px-4 py-3 prose prose-sm dark:prose-invert max-w-none whitespace-pre-wrap">
                            {{ $doc->content }}
                        </div>
                        @if ($doc->file_path)
                            <div class="px-4 pb-3">
                                <flux:button size="sm" variant="ghost" icon="arrow-down-tray"
                                             :href="\Illuminate\Support\Facades\Storage::url($doc->file_path)" target="_blank">
                                    Pobierz załącznik
                                </flux:button>
                            </div>
                        @endif
                    </details>
                @endforeach
            </div>
        @endif
    @else
        @if ($this->tutorials->isEmpty())
            <div class="text-center py-16 text-zinc-400">
                <flux:icon name="academic-cap" class="w-12 h-12 mx-auto mb-3 opacity-40" />
                <flux:text>Brak tutoriali.</flux:text>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($this->tutorials as $tut)
                    <details class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <summary class="cursor-pointer px-4 py-3 bg-zinc-50 dark:bg-zinc-900">
                            <flux:heading size="md">{{ $tut->name }}</flux:heading>
                        </summary>
                        <div class="px-4 py-3 whitespace-pre-wrap text-sm">
                            {{ $tut->content }}
                        </div>
                    </details>
                @endforeach
            </div>
        @endif
    @endif
</div>
