<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Moje postacie</flux:heading>
        <flux:button :href="route('character.create')" wire:navigate variant="primary" icon="plus">
            Nowa postać
        </flux:button>
    </div>

    @if ($this->characters->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="user" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Nie masz jeszcze żadnej postaci. Utwórz pierwszą!</flux:text>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($this->characters as $character)
                <a href="{{ route('character.show', $character->id) }}" wire:navigate
                   class="block rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                    <div class="flex items-center gap-3 mb-2">
                        <flux:avatar :name="$character->name" :src="$character->avatar ?: null" />
                        <div>
                            <flux:heading size="lg">{{ $character->name }}</flux:heading>
                            <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $character->race ?: '—' }} · {{ $character->age ? $character->age.' lat' : 'wiek nieznany' }}
                            </flux:text>
                        </div>
                    </div>
                    @if ($character->biography)
                        <flux:text class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                            {{ $character->biography }}
                        </flux:text>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
