<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Odznaki</flux:heading>
        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
            Zdobyto: <strong>{{ count($this->myBadgeIds) }}</strong> / {{ $this->allBadges->count() }}
        </flux:text>
    </div>

    @if ($this->allBadges->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="sparkles" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Brak odznak w systemie.</flux:text>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($this->allBadges as $badge)
                @php $owned = in_array($badge->id, $this->myBadgeIds, true); @endphp
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 text-center
                            {{ $owned ? 'bg-amber-50 dark:bg-amber-900/10 border-amber-300 dark:border-amber-700' : 'opacity-60' }}">
                    <div class="mx-auto mb-3 w-16 h-16 rounded-full flex items-center justify-center
                                {{ $owned ? 'bg-amber-200 dark:bg-amber-800/40 text-amber-700 dark:text-amber-200' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' }}">
                        <flux:icon :name="$badge->icon ?: 'sparkles'" class="w-8 h-8" />
                    </div>
                    <flux:heading size="md" class="mb-1">{{ $badge->name }}</flux:heading>
                    <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">{{ $badge->description }}</flux:text>
                    @if ($owned)
                        <flux:badge color="amber" size="sm" class="mt-2">zdobyte</flux:badge>
                    @else
                        <flux:badge color="zinc" size="sm" class="mt-2">zablokowane</flux:badge>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
