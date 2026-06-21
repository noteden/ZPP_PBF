<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('character.index') }}" wire:navigate class="hover:underline">Moje postacie</a>
        <span class="mx-1">›</span>
        <a href="{{ route('character.show', $character->id) }}" wire:navigate class="hover:underline">{{ $character->name }}</a>
        <span class="mx-1">›</span>
        <span>Edycja</span>
    </div>

    <flux:heading size="xl" class="mb-6">Edytuj postać</flux:heading>

    <form wire:submit="save" class="space-y-4">
        <flux:input wire:model="name" label="Imię i nazwisko" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="age" type="number" label="Wiek" />
            <flux:input wire:model="race" label="Rasa" />
        </div>

        <flux:input wire:model="origin" label="Pochodzenie" />

        <flux:input wire:model="avatar" label="Avatar (URL)" placeholder="https://..." />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="eyes" label="Oczy" />
            <flux:input wire:model="hair" label="Włosy" />
        </div>

        <flux:textarea wire:model="biography" label="Biografia" rows="8" />

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <div class="flex items-center justify-between mb-3">
                <flux:heading size="md">Statystyki</flux:heading>
                <flux:button size="sm" variant="ghost" icon="plus" wire:click="addStat" type="button">Dodaj</flux:button>
            </div>

            @if (empty($stats))
                <flux:text class="text-sm text-zinc-400">Brak statystyk. Dodaj np. Siła, Zręczność, Inteligencja.</flux:text>
            @else
                <div class="space-y-2">
                    @foreach ($stats as $i => $stat)
                        <div class="flex items-center gap-2" wire:key="stat-{{ $i }}">
                            <div class="flex-1">
                                <flux:input wire:model="stats.{{ $i }}.name" placeholder="Nazwa (np. Siła)" />
                            </div>
                            <div class="w-28 shrink-0">
                                <flux:input wire:model="stats.{{ $i }}.value" placeholder="Wartość" />
                            </div>
                            <flux:button size="sm" variant="ghost" icon="trash" wire:click="removeStat({{ $i }})" type="button" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex justify-end gap-2">
            <flux:button :href="route('character.show', $character->id)" wire:navigate variant="ghost">Anuluj</flux:button>
            <flux:button type="submit" variant="primary">Zapisz zmiany</flux:button>
        </div>
    </form>
</div>
