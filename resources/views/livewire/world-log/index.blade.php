<div class="max-w-3xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-2">Kronika świata</flux:heading>
    <flux:text class="text-zinc-500 dark:text-zinc-400 mb-8">
        Historia wydarzeń świata gry — wojny, kataklizmy, doniosłe czyny bohaterów.
    </flux:text>

    @if ($this->logs->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="book-open" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Kronika jest jeszcze pusta.</flux:text>
        </div>
    @else
        <div class="relative border-s border-zinc-200 dark:border-zinc-700 ms-2 space-y-8">
            @foreach ($this->logs as $log)
                <div class="ms-6">
                    <span class="absolute -start-1.5 flex h-3 w-3 rounded-full bg-blue-500 ring-4 ring-white dark:ring-zinc-800"></span>
                    <div class="flex items-center gap-2 mb-1">
                        <flux:heading size="lg">{{ $log->title }}</flux:heading>
                        @if ($log->occurred_on)
                            <flux:badge color="zinc" size="sm">{{ $log->occurred_on->format('d.m.Y') }}</flux:badge>
                        @endif
                    </div>
                    <div class="whitespace-pre-wrap text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed">{{ $log->body }}</div>
                    @if ($log->user)
                        <flux:text class="text-xs text-zinc-400 mt-1">zapisał: {{ $log->user->name }}</flux:text>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
