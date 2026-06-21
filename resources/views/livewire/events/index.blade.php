<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Wydarzenia</flux:heading>
        <flux:button wire:click="$set('showModal', true)" variant="primary" icon="plus">
            Nowe wydarzenie
        </flux:button>
    </div>

    {{-- Nadchodzące --}}
    <flux:heading size="lg" class="mb-3">Nadchodzące</flux:heading>
    @if ($this->upcoming->isEmpty())
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-6 text-sm text-zinc-400">
            Brak nadchodzących wydarzeń.
        </div>
    @else
        <div class="space-y-3 mb-8">
            @foreach ($this->upcoming as $event)
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 flex items-start gap-4">
                    <div class="shrink-0 text-center w-16">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $event->date->format('d') }}</div>
                        <div class="text-xs uppercase text-zinc-500">{{ $event->date->translatedFormat('M Y') }}</div>
                        <div class="text-xs text-zinc-400 mt-1">{{ $event->date->format('H:i') }}</div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <flux:heading size="md">{{ $event->name }}</flux:heading>
                            <flux:badge color="purple" size="sm">{{ $event->type }}</flux:badge>
                        </div>
                        <flux:text class="text-sm text-zinc-600 dark:text-zinc-300 mt-1">{{ $event->description }}</flux:text>
                        <flux:text class="text-xs text-zinc-400 mt-2">
                            Organizuje: {{ $event->user?->name ?? 'Nieznany' }}
                        </flux:text>
                    </div>
                    @if ($event->user_id === auth()->id() || auth()->user()?->isModerator())
                        <flux:button size="xs" variant="ghost" icon="trash" wire:click="delete({{ $event->id }})"
                                     wire:confirm="Na pewno usunąć?" />
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Minione --}}
    <flux:heading size="lg" class="mb-3">Minione</flux:heading>
    @if ($this->past->isEmpty())
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-6 text-sm text-zinc-400">
            Brak minionych wydarzeń.
        </div>
    @else
        <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @foreach ($this->past as $event)
                <div class="px-4 py-3 flex items-center gap-4 opacity-70">
                    <div class="shrink-0 w-24 text-xs text-zinc-500">{{ $event->date->format('Y-m-d H:i') }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ $event->name }}</div>
                        <div class="text-xs text-zinc-400">{{ $event->type }} · {{ $event->user?->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Modal --}}
    <flux:modal wire:model.live="showModal" name="new-event">
        <form wire:submit="save" class="space-y-4 p-1">
            <flux:heading size="lg">Nowe wydarzenie</flux:heading>

            <flux:input wire:model="name" label="Nazwa" placeholder="np. Sesja w Karczmie pod Smokiem" />

            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Typ</label>
                <select wire:model="type"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm">
                    <option value="sesja">Sesja</option>
                    <option value="turniej">Turniej</option>
                    <option value="spotkanie">Spotkanie</option>
                    <option value="inne">Inne</option>
                </select>
            </div>

            <flux:input wire:model="date" type="datetime-local" label="Data i godzina" />

            <flux:textarea wire:model="description" label="Opis" rows="4" placeholder="Szczegóły wydarzenia..." />

            <div class="flex justify-end gap-2">
                <flux:button type="button" wire:click="$set('showModal', false)" variant="ghost">Anuluj</flux:button>
                <flux:button type="submit" variant="primary">Utwórz</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
