<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('character.index') }}" wire:navigate class="hover:underline">Moje postacie</a>
        <span class="mx-1">›</span>
        <span>{{ $character->name }}</span>
    </div>

    <div class="flex items-start gap-4 mb-8">
        <flux:avatar :name="$character->name" :src="$character->avatar ?: null" size="lg" />
        <div class="flex-1">
            <flux:heading size="xl">{{ $character->name }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">
                {{ $character->race ?: '—' }} · {{ $character->age ? $character->age.' lat' : 'wiek nieznany' }} ·
                {{ $character->origin ?: 'pochodzenie nieznane' }}
            </flux:text>
            <flux:text class="text-sm text-zinc-400 mt-1">
                Gracz: <strong>{{ $character->user?->name }}</strong>
            </flux:text>
            <div class="flex items-center gap-2 mt-2">
                <flux:badge color="indigo" size="sm" icon="bolt">{{ $character->experience }} XP</flux:badge>
                <flux:badge color="purple" size="sm" icon="book-open">{{ $character->history_points }} PH</flux:badge>
            </div>
        </div>
        @if ($character->user_id === auth()->id())
            <flux:button :href="route('character.edit', $character->id)" wire:navigate variant="ghost" icon="pencil-square">
                Edytuj
            </flux:button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Wygląd --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <flux:heading size="md" class="mb-3">Wygląd</flux:heading>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between gap-3">
                    <dt class="text-zinc-500 dark:text-zinc-400">Oczy</dt>
                    <dd class="text-right">{{ $character->eyes ?: '—' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-zinc-500 dark:text-zinc-400">Włosy</dt>
                    <dd class="text-right">{{ $character->hair ?: '—' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-zinc-500 dark:text-zinc-400">Rasa</dt>
                    <dd class="text-right">{{ $character->race ?: '—' }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-zinc-500 dark:text-zinc-400">Wiek</dt>
                    <dd class="text-right">{{ $character->age ?: '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Statystyki --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <flux:heading size="md" class="mb-3">Statystyki</flux:heading>
            @php $stats = $character->sheet?->statistic ?? []; @endphp
            @if (empty($stats))
                <flux:text class="text-sm text-zinc-400">Brak statystyk. MG dopisze.</flux:text>
            @else
                <dl class="space-y-2 text-sm">
                    @foreach ($stats as $key => $value)
                        <div class="flex justify-between gap-3">
                            <dt class="text-zinc-500 dark:text-zinc-400 capitalize">{{ $key }}</dt>
                            <dd class="text-right font-mono">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>

        {{-- Odznaki gracza --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <flux:heading size="md" class="mb-3">Odznaki gracza</flux:heading>
            @php $userBadges = $character->user?->badges ?? collect(); @endphp
            @if ($userBadges->isEmpty())
                <flux:text class="text-sm text-zinc-400">Gracz nie ma jeszcze odznak.</flux:text>
            @else
                <div class="flex flex-wrap gap-2">
                    @foreach ($userBadges as $badge)
                        <flux:badge color="amber" size="sm">{{ $badge->name }}</flux:badge>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Umiejętności --}}
    <div class="mt-6 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
        <div class="flex items-center justify-between mb-3">
            <flux:heading size="md">Umiejętności</flux:heading>
            @if ($character->user_id === auth()->id())
                <flux:button :href="route('character.skills', $character->id)" wire:navigate size="sm" variant="ghost" icon="plus">
                    Zgłoś umiejętność
                </flux:button>
            @endif
        </div>
        @php $skills = $character->sheet?->skills ?? collect(); @endphp
        @if ($skills->isEmpty())
            <flux:text class="text-sm text-zinc-400">Brak umiejętności na arkuszu.</flux:text>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($skills as $skill)
                    <div class="flex items-center justify-between rounded-lg bg-zinc-50 dark:bg-zinc-800 px-3 py-2">
                        <div>
                            <div class="text-sm font-medium">{{ $skill->name }}</div>
                            @if ($skill->description)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $skill->description }}</div>
                            @endif
                        </div>
                        @if (isset($skill->pivot->level))
                            <flux:badge color="blue" size="sm">poz. {{ $skill->pivot->level }}</flux:badge>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Ekwipunek --}}
    <div class="mt-6 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
        <flux:heading size="md" class="mb-3">Ekwipunek</flux:heading>
        @php $equipment = $character->sheet?->equipment ?? collect(); @endphp
        @if ($equipment->isEmpty())
            <flux:text class="text-sm text-zinc-400">Brak przedmiotów.</flux:text>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($equipment as $item)
                    <div class="flex items-center justify-between rounded-lg bg-zinc-50 dark:bg-zinc-800 px-3 py-2">
                        <div>
                            <div class="text-sm font-medium flex items-center gap-2">
                                {{ $item->name }}
                                @if (!empty($item->pivot->is_equipped))
                                    <flux:badge color="green" size="sm">założone</flux:badge>
                                @endif
                            </div>
                            @if ($item->description)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item->description }}</div>
                            @endif
                        </div>
                        @if (!empty($item->pivot->number) && $item->pivot->number > 1)
                            <flux:badge color="zinc" size="sm">×{{ $item->pivot->number }}</flux:badge>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Biografia --}}
    @if ($character->biography)
        <div class="mt-6 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <flux:heading size="md" class="mb-3">Biografia</flux:heading>
            <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $character->biography }}</div>
        </div>
    @endif
</div>
