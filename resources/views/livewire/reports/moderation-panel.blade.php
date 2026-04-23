<div class="max-w-4xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-6">Panel moderacji</flux:heading>

    <div class="flex gap-3 mb-6">
        <flux:button wire:click="$set('filter', 'oczekujące')"
                     :variant="$filter === 'oczekujące' ? 'primary' : 'ghost'">
            Oczekujące
        </flux:button>
        <flux:button wire:click="$set('filter', 'rozpatrzone')"
                     :variant="$filter === 'rozpatrzone' ? 'primary' : 'ghost'">
            Rozpatrzone
        </flux:button>
    </div>

    @if ($this->reports->isEmpty())
        <div class="text-center py-16 text-zinc-400">
            <flux:icon name="shield-check" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Brak zgłoszeń w tej kategorii.</flux:text>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @foreach ($this->reports as $report)
                <div class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm font-medium">
                                Zgłoszenie od {{ $report->user->name ?? 'Nieznany' }}
                            </flux:text>
                            <flux:text class="text-xs text-zinc-400">
                                Post autora: {{ $report->post->user->name ?? '?' }}
                            </flux:text>
                            <flux:text class="text-sm mt-1">{{ $report->reason }}</flux:text>
                            <flux:text class="text-xs text-zinc-400 mt-1">
                                {{ $report->created_at->format('d.m.Y H:i') }}
                            </flux:text>
                        </div>
                        @if ($filter === 'oczekujące')
                            <flux:button wire:click="markReviewed({{ $report->id }})" size="sm" variant="primary">
                                Rozpatrz
                            </flux:button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $this->reports->links() }}
        </div>
    @endif
</div>
