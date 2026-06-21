<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('forum.index') }}" wire:navigate class="hover:underline">Forum</a>
        <span class="mx-1">›</span>
        <a href="{{ route('forum.show', $forum->id) }}" wire:navigate class="hover:underline">{{ $forum->name }}</a>
        <span class="mx-1">›</span>
        <span>Nowy wątek</span>
    </div>

    <flux:heading size="xl" class="mb-6">Nowy wątek</flux:heading>

    <form wire:submit="save" class="space-y-4">
        <flux:input wire:model="name" label="Tytuł wątku" placeholder="O czym dyskutujemy?" />

        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tag</label>
            <select wire:model="tag"
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm">
                @foreach (\App\Enums\PostTag::cases() as $t)
                    <option value="{{ $t->value }}">{{ $t->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Postać (opcjonalnie)</label>
            <select wire:model="charakter_id"
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm">
                <option value="">— Piszę jako ja (poza grą) —</option>
                @foreach ($this->characters as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <flux:textarea wire:model="content" label="Pierwszy post" rows="8" placeholder="Treść pierwszego posta..." />

        <div class="flex justify-end gap-2">
            <flux:button :href="route('forum.show', $forum->id)" wire:navigate variant="ghost">Anuluj</flux:button>
            <flux:button type="submit" variant="primary">Utwórz wątek</flux:button>
        </div>
    </form>
</div>
