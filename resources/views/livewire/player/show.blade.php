<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="flex items-center gap-4 mb-8">
        <div class="relative shrink-0">
            <flux:avatar :name="$user->name" size="lg" />
            <span class="absolute -bottom-0.5 -right-0.5 block h-3.5 w-3.5 rounded-full ring-2 ring-white dark:ring-zinc-900
                {{ $user->isOnline() ? 'bg-green-500' : 'bg-zinc-400' }}"
                title="{{ $user->isOnline() ? 'Online' : 'Offline' }}"></span>
        </div>
        <div>
            <flux:heading size="xl">{{ $user->name }}</flux:heading>
            <div class="flex items-center gap-2 mt-1">
                <flux:badge :color="$user->role->color()" size="sm">{{ $user->getRoleLabel() }}</flux:badge>
                <flux:text class="text-sm text-zinc-500">
                    {{ $user->isOnline() ? 'Online' : 'Ostatnio: '.($user->last_seen_at?->diffForHumans() ?? 'nigdy') }}
                </flux:text>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 text-center">
            <div class="text-2xl font-bold">{{ $user->charakters_count }}</div>
            <div class="text-xs text-zinc-400">postaci</div>
        </div>
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 text-center">
            <div class="text-2xl font-bold">{{ $user->posts_count }}</div>
            <div class="text-xs text-zinc-400">postów</div>
        </div>
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 text-center">
            <div class="text-2xl font-bold">{{ $user->badges_count }}</div>
            <div class="text-xs text-zinc-400">odznak</div>
        </div>
    </div>

    <flux:heading size="lg" class="mb-3">Postacie</flux:heading>
    @if ($this->characters->isEmpty())
        <flux:text class="text-zinc-400">Ten gracz nie ma jeszcze postaci.</flux:text>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
            @foreach ($this->characters as $character)
                <div class="flex items-center gap-3 rounded-xl border border-zinc-200 dark:border-zinc-700 p-3">
                    <flux:avatar :name="$character->name" :src="$character->avatar ?: null" />
                    <div class="min-w-0">
                        <flux:heading size="sm" class="truncate">{{ $character->name }}</flux:heading>
                        <flux:text class="text-xs text-zinc-400">
                            {{ $character->race ?: '—' }} · {{ $character->experience }} XP
                        </flux:text>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <flux:heading size="lg" class="mb-3">Odznaki</flux:heading>
    @if ($this->badges->isEmpty())
        <flux:text class="text-zinc-400">Brak zdobytych odznak.</flux:text>
    @else
        <div class="flex flex-wrap gap-2">
            @foreach ($this->badges as $badge)
                <flux:badge color="amber" icon="sparkles">{{ $badge->name }}</flux:badge>
            @endforeach
        </div>
    @endif
</div>
