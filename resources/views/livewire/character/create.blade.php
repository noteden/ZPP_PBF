<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('character.index') }}" wire:navigate class="hover:underline">Moje postacie</a>
        <span class="mx-1">›</span>
        <span>Nowa postać</span>
    </div>

    <flux:heading size="xl" class="mb-6">Nowa postać</flux:heading>

    <form wire:submit="save" class="space-y-4">
        <flux:input wire:model="name" label="Imię i nazwisko" placeholder="np. Aldur z Lasów" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="age" type="number" label="Wiek" placeholder="np. 27" />
            <flux:input wire:model="race" label="Rasa" placeholder="np. Elf" />
        </div>

        <flux:input wire:model="origin" label="Pochodzenie" placeholder="np. Krainy Północy" />

        <flux:input wire:model="avatar" label="Avatar (URL)" placeholder="https://..." />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="eyes" label="Oczy" placeholder="np. zielone" />
            <flux:input wire:model="hair" label="Włosy" placeholder="np. siwe, długie" />
        </div>

        <flux:textarea wire:model="biography" label="Biografia" rows="8" placeholder="Opisz historię postaci..." />

        <div class="flex justify-end gap-2">
            <flux:button :href="route('character.index')" wire:navigate variant="ghost">Anuluj</flux:button>
            <flux:button type="submit" variant="primary">Utwórz postać</flux:button>
        </div>
    </form>
</div>
