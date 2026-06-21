<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('character.index') }}" wire:navigate class="hover:underline">Moje postacie</a>
        <span class="mx-1">›</span>
        <a href="{{ route('character.show', $character->id) }}" wire:navigate class="hover:underline">{{ $character->name }}</a>
        <span class="mx-1">›</span>
        <span>Karta postaci</span>
    </div>

    <flux:heading size="xl" class="mb-2">Karta postaci — {{ $character->name }}</flux:heading>
    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">
        Zgłoś nową umiejętność lub technikę. Mistrz Gry musi ją zatwierdzić zanim zacznie obowiązywać.
    </flux:text>

    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 mb-8">
        <flux:heading size="md" class="mb-3">Zgłoś umiejętność</flux:heading>
        <form wire:submit="submit" class="space-y-3">
            <flux:input wire:model="skillName" label="Nazwa" placeholder="np. Mistrzowskie władanie mieczem" />
            <flux:textarea wire:model="skillDescription" label="Opis" rows="4"
                           placeholder="Opisz działanie umiejętności..." />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane">Zgłoś do akceptacji</flux:button>
            </div>
        </form>
    </div>

    <flux:heading size="lg" class="mb-3">Umiejętności postaci</flux:heading>
    @if ($this->skills->isEmpty())
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-6 text-sm text-zinc-400">
            Brak zgłoszonych umiejętności.
        </div>
    @else
        <div class="space-y-2">
            @foreach ($this->skills as $skill)
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 dark:border-zinc-700 px-4 py-3">
                    <div>
                        <div class="text-sm font-medium flex items-center gap-2">
                            {{ $skill->name }}
                            @if (isset($skill->pivot->level))
                                <flux:badge color="blue" size="sm">poz. {{ $skill->pivot->level }}</flux:badge>
                            @endif
                        </div>
                        @if ($skill->description)
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $skill->description }}</div>
                        @endif
                    </div>
                    @if ($skill->accepted)
                        <flux:badge color="green" size="sm">zatwierdzona</flux:badge>
                    @else
                        <flux:badge color="yellow" size="sm">oczekuje na MG</flux:badge>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Ekwipunek --}}
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 my-8">
        <flux:heading size="md" class="mb-3">Dodaj ekwipunek</flux:heading>
        <form wire:submit="addEquipment" class="space-y-3">
            <flux:input wire:model="equipmentName" label="Nazwa" placeholder="np. Stalowy miecz" />
            <flux:textarea wire:model="equipmentDescription" label="Opis" rows="3"
                           placeholder="Opis przedmiotu..." />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="plus">Dodaj przedmiot</flux:button>
            </div>
        </form>
    </div>

    <flux:heading size="lg" class="mb-3">Ekwipunek postaci</flux:heading>
    @if ($this->equipment->isEmpty())
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-6 text-sm text-zinc-400">
            Brak przedmiotów w ekwipunku.
        </div>
    @else
        <div class="space-y-2">
            @foreach ($this->equipment as $item)
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 dark:border-zinc-700 px-4 py-3">
                    <div>
                        <div class="text-sm font-medium">{{ $item->name }}</div>
                        @if ($item->description)
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item->description }}</div>
                        @endif
                    </div>
                    <flux:button size="xs" variant="ghost" icon="trash"
                                 wire:click="removeEquipment({{ $item->id }})"
                                 wire:confirm="Usunąć przedmiot z ekwipunku?" />
                </div>
            @endforeach
        </div>
    @endif
</div>
