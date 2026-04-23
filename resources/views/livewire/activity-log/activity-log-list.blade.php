<div class="max-w-4xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-6">Log aktywności</flux:heading>

    <div class="flex flex-wrap gap-3 mb-6">
        <div>
            <label class="block text-xs text-zinc-500 mb-1">Akcja</label>
            <select wire:model.live="filterAction"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-1.5 text-sm">
                <option value="">Wszystkie</option>
                <option value="created">Dodano</option>
                <option value="updated">Edytowano</option>
                <option value="deleted">Usunięto</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-zinc-500 mb-1">Typ</label>
            <select wire:model.live="filterSubject"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-1.5 text-sm">
                <option value="">Wszystkie</option>
                <option value="Post">Post</option>
                <option value="Thread">Wątek</option>
            </select>
        </div>
    </div>

    @if ($this->logs->isEmpty())
        <div class="text-center py-16 text-zinc-400">
            <flux:icon name="clock" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Brak wpisów spełniających kryteria.</flux:text>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @foreach ($this->logs as $log)
                @php
                    $colors = ['created' => 'text-green-500', 'updated' => 'text-blue-500', 'deleted' => 'text-red-500'];
                    $icons  = ['created' => 'plus-circle', 'updated' => 'pencil', 'deleted' => 'trash'];
                    $labels = ['created' => 'Dodano', 'updated' => 'Edytowano', 'deleted' => 'Usunięto'];
                @endphp
                <div class="flex items-start gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <flux:icon :name="$icons[$log->action] ?? 'information-circle'"
                               class="w-4 h-4 mt-0.5 shrink-0 {{ $colors[$log->action] ?? 'text-zinc-400' }}" />
                    <div class="flex-1 min-w-0">
                        <flux:text class="text-sm">{{ $log->description }}</flux:text>
                        <div class="flex items-center gap-2 mt-0.5">
                            <flux:badge size="sm" color="{{ match($log->action) { 'created' => 'green', 'updated' => 'blue', 'deleted' => 'red', default => 'zinc' } }}">
                                {{ $labels[$log->action] ?? $log->action }}
                            </flux:badge>
                            <flux:badge size="sm" color="zinc">{{ $log->subject_type }}</flux:badge>
                        </div>
                    </div>
                    <flux:text class="text-xs text-zinc-400 shrink-0 mt-0.5">
                        {{ $log->created_at->format('d.m.Y H:i') }}
                    </flux:text>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $this->logs->links() }}</div>
    @endif
</div>
