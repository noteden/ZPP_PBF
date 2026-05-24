<div class="max-w-2xl mx-auto py-8 px-4 flex flex-col gap-4"
     x-data="{ msg: '' }"
     x-on:message-sent.window="msg = ''">

    {{-- Nagłówek --}}
    <div class="flex items-center gap-3">
        <flux:button href="{{ route('messages.index') }}" wire:navigate variant="ghost" icon="arrow-left" size="sm" />
        <flux:avatar :name="$partner->name" />
        <flux:heading size="lg">{{ $partner->name }}</flux:heading>
    </div>

    {{-- Lista wiadomości --}}
    <div class="flex flex-col gap-3 min-h-64 max-h-[60vh] overflow-y-auto rounded-xl border border-zinc-200 dark:border-zinc-700 p-4"
         x-data x-init="$el.scrollTop = $el.scrollHeight"
         x-on:livewire:updated.window="$el.scrollTop = $el.scrollHeight"
         wire:poll.5s>

        @forelse ($this->messages as $message)
            @php $isMine = $message->sender_user_id == auth()->id(); @endphp

            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] {{ $isMine
                    ? 'bg-blue-600 text-white rounded-2xl rounded-br-sm'
                    : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 rounded-2xl rounded-bl-sm'
                }} px-4 py-2">
                    <p class="text-sm whitespace-pre-wrap">{{ $message->content }}</p>
                    <p class="text-xs mt-1 {{ $isMine ? 'text-blue-200' : 'text-zinc-400' }}">
                        {{ $message->created_at->format('H:i, d.m.Y') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center text-zinc-400 py-8">
                <flux:text>Zacznij rozmowę z {{ $partner->name }}.</flux:text>
            </div>
        @endforelse
    </div>

    {{-- Formularz wysyłania --}}
    <form class="flex gap-2 items-end"
          x-on:submit.prevent="$wire.sendMessage(msg)">
        <textarea
            x-model="msg"
            rows="2"
            placeholder="Napisz wiadomość..."
            class="flex-1 rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            x-on:keydown="if ($event.key === 'Enter' && !$event.shiftKey) { $event.preventDefault(); $wire.sendMessage(msg) }"
        ></textarea>
        <flux:button type="submit" variant="primary" icon="paper-airplane">
            Wyślij
        </flux:button>
    </form>

    <flux:text class="text-xs text-zinc-400 text-center">
        Enter — wyślij &nbsp;·&nbsp; Shift+Enter — nowa linia
    </flux:text>

    @error('content')
        <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
