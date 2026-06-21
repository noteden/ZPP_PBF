<div class="max-w-3xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-6">Sugestie</flux:heading>

    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 mb-8">
        <flux:heading size="md" class="mb-3">Wyślij sugestię</flux:heading>
        <form wire:submit="save" class="space-y-3">
            <flux:input wire:model="name" label="Tytuł" placeholder="np. Dodać kalendarz sesji" />
            <flux:textarea wire:model="content" label="Treść" rows="5" placeholder="Opisz swoją sugestię..." />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane">Wyślij</flux:button>
            </div>
        </form>
    </div>

    <flux:heading size="lg" class="mb-3">Moje sugestie</flux:heading>
    @if ($this->mySuggestions->isEmpty())
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-6 text-sm text-zinc-400">
            Nie wysłałeś jeszcze żadnej sugestii.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($this->mySuggestions as $s)
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <flux:heading size="md">{{ $s->name }}</flux:heading>
                        <flux:text class="text-xs text-zinc-400">{{ $s->created_at->diffForHumans() }}</flux:text>
                    </div>
                    <flux:text class="text-sm text-zinc-600 dark:text-zinc-300 whitespace-pre-wrap">{{ $s->content }}</flux:text>
                </div>
            @endforeach
        </div>
    @endif
</div>
