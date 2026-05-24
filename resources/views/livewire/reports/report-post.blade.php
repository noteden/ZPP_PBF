<div>
    @if ($submitted)
        <flux:badge color="green" size="sm">Zgłoszono</flux:badge>
    @else
        <flux:button wire:click="$set('showModal', true)" variant="ghost" size="sm" icon="flag">
            Zgłoś
        </flux:button>
    @endif

    <flux:modal wire:model.live="showModal" name="report-{{ $post->id }}">
        <div class="flex flex-col gap-4 p-4">
            <flux:heading size="lg">Zgłoś post</flux:heading>
            <flux:textarea wire:model="reason" rows="4" placeholder="Opisz powód zgłoszenia..." />
            @error('reason')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <div class="flex justify-end gap-2">
                <flux:button wire:click="$set('showModal', false)" variant="ghost">Anuluj</flux:button>
                <flux:button wire:click="submit" variant="danger">Wyślij zgłoszenie</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
