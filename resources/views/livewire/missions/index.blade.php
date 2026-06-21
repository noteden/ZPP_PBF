<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Misje</flux:heading>
    </div>

    {{-- Zgłoszenie misji/fabuły --}}
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 mb-8">
        <flux:heading size="md" class="mb-3">Zgłoś misję / fabułę</flux:heading>
        <form wire:submit="propose" class="space-y-3">
            <flux:input wire:model="name" label="Tytuł" placeholder="np. Oblężenie Czarnej Wieży" />
            <flux:textarea wire:model="description" label="Opis" rows="4"
                           placeholder="Opisz proponowaną misję lub wątek fabularny..." />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane">Zgłoś</flux:button>
            </div>
        </form>
    </div>

    @if ($this->missions->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="map" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Nie zgłoszono jeszcze żadnych misji.</flux:text>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($this->missions as $mission)
                @php
                    $joined   = in_array($mission->id, $this->myMissionIds, true);
                    $review   = $this->myReviews[$mission->id] ?? null;
                    $reviewed = $review && (bool) $review->review;
                    $myRating = $review->rating ?? null;
                    $avg      = $mission->averageRating();
                @endphp
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <flux:heading size="lg">{{ $mission->name }}</flux:heading>
                                @if ($joined)
                                    <flux:badge color="blue" size="sm">dołączono</flux:badge>
                                @endif
                                @if ($reviewed)
                                    <flux:badge color="green" size="sm">ukończono</flux:badge>
                                @endif
                                @if ($avg !== null)
                                    <flux:badge color="amber" size="sm" icon="star">{{ $avg }} / 5 ({{ $mission->ratingsCount() }})</flux:badge>
                                @endif
                            </div>
                            <flux:text class="text-sm text-zinc-600 dark:text-zinc-300">{{ $mission->description }}</flux:text>
                            @if ($mission->proposer)
                                <flux:text class="text-xs text-zinc-400 mt-1">Zgłosił: {{ $mission->proposer->name }}</flux:text>
                            @endif
                        </div>
                        <div class="shrink-0 flex flex-col gap-2">
                            @if ($joined)
                                <flux:button size="sm" variant="ghost" wire:click="leave({{ $mission->id }})">
                                    Opuść
                                </flux:button>
                                <flux:button size="sm" variant="primary" wire:click="toggleReview({{ $mission->id }})">
                                    {{ $reviewed ? 'Cofnij ukończenie' : 'Oznacz ukończoną' }}
                                </flux:button>
                            @else
                                <flux:button size="sm" variant="primary" icon="plus" wire:click="join({{ $mission->id }})">
                                    Dołącz
                                </flux:button>
                            @endif
                        </div>
                    </div>

                    @if (auth()->user()?->isModerator())
                        <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700 flex items-center gap-2">
                            <flux:text class="text-xs text-zinc-500">Twoja ocena (werdykt):</flux:text>
                            @for ($s = 1; $s <= 5; $s++)
                                <button wire:click="rate({{ $mission->id }}, {{ $s }})"
                                        class="text-lg {{ $myRating !== null && $s <= $myRating ? 'text-amber-500' : 'text-zinc-400 hover:text-amber-400' }}"
                                        title="{{ $s }}/5">★</button>
                            @endfor
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
