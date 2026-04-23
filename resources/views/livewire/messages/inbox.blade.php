<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">Wiadomości</flux:heading>
        <flux:button wire:click="openNewMessage" variant="primary" icon="pencil-square">
            Nowa wiadomość
        </flux:button>
    </div>

    @if ($this->conversations->isEmpty())
        <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
            <flux:icon name="envelope" class="w-12 h-12 mx-auto mb-3 opacity-40" />
            <flux:text>Nie masz jeszcze żadnych wiadomości.</flux:text>
        </div>
    @else
        <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @foreach ($this->conversations as $conv)
                <a href="{{ route('messages.conversation', $conv->partner->id) }}" wire:navigate
                   class="flex items-center gap-4 px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                    <flux:avatar :name="$conv->partner->name" class="shrink-0" />

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <flux:heading size="sm" class="truncate">{{ $conv->partner->name }}</flux:heading>
                            <flux:text class="text-xs text-zinc-400 shrink-0">
                                {{ $conv->last_message->created_at->diffForHumans() }}
                            </flux:text>
                        </div>
                        <flux:text class="truncate text-sm text-zinc-500 dark:text-zinc-400">
                            @if ($conv->last_message->sender_user_id === auth()->id())
                                <span class="text-zinc-400">Ty: </span>
                            @endif
                            {{ $conv->last_message->content }}
                        </flux:text>
                    </div>

                    @if ($conv->unread > 0)
                        <flux:badge color="blue" size="sm">{{ $conv->unread }}</flux:badge>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    {{-- Modal nowej wiadomości --}}
    <flux:modal wire:model.live="showNewMessageModal" name="new-message">
        <div class="space-y-4 p-1">
            <flux:heading size="lg">Nowa wiadomość</flux:heading>

            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Do kogo?</label>
                <select wire:model.live="selectedUserId"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Wybierz użytkownika...</option>
                    @foreach ($this->availableUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('selectedUserId')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <flux:textarea wire:model="newMessageContent" label="Treść" rows="4"
                           placeholder="Napisz wiadomość..." />

            <div class="flex justify-end gap-2">
                <flux:button wire:click="$set('showNewMessageModal', false)" variant="ghost">
                    Anuluj
                </flux:button>
                <flux:button wire:click="sendNewMessage" variant="primary">
                    Wyślij
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
