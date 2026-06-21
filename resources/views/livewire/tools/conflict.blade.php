<div class="max-w-3xl mx-auto py-8 px-4">
    <flux:heading size="xl" class="mb-2">Rozstrzyganie konfliktów</flux:heading>
    <flux:text class="text-zinc-500 dark:text-zinc-400 mb-6">
        Rzuć kością, aby rozstrzygnąć walkę lub wydarzenie fabularne. Wynik interpretuj zgodnie z tabelą poniżej.
    </flux:text>

    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Kość</label>
                <select wire:model="sides"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                    @foreach ($dice as $d)
                        <option value="{{ $d }}">k{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <flux:input wire:model="modifier" type="number" label="Modyfikator" />
            <flux:button wire:click="roll" variant="primary" icon="sparkles">Rzuć</flux:button>
        </div>

        @if ($lastRoll !== null)
            <div class="mt-6 text-center">
                <div class="text-5xl font-bold">{{ $lastTotal }}</div>
                <flux:text class="text-sm text-zinc-500">
                    rzut: {{ $lastRoll }} {{ $modifier !== 0 ? ($modifier > 0 ? '+ '.$modifier : '- '.abs($modifier)) : '' }}
                </flux:text>
            </div>
        @endif
    </div>

    @if (!empty($history))
        <flux:heading size="lg" class="mb-3">Historia rzutów</flux:heading>
        <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden mb-8">
            @foreach ($history as $h)
                <div class="flex items-center justify-between px-4 py-2 text-sm">
                    <span class="text-zinc-500">{{ $h['die'] }} → {{ $h['roll'] }}{{ $h['modifier'] ? ' ('.($h['modifier'] > 0 ? '+' : '').$h['modifier'].')' : '' }}</span>
                    <span class="font-semibold">{{ $h['total'] }}</span>
                    <flux:badge size="sm" :color="str_contains($h['outcome'], 'Sukces') ? 'green' : 'red'">{{ $h['outcome'] }}</flux:badge>
                </div>
            @endforeach
        </div>
    @endif

    <flux:heading size="lg" class="mb-3">Tabela rozstrzygania</flux:heading>
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800 text-left">
                <tr>
                    <th class="px-4 py-2 font-medium">Wynik rzutu</th>
                    <th class="px-4 py-2 font-medium">Rezultat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <tr><td class="px-4 py-2">Maksymalny wynik kości</td><td class="px-4 py-2 text-green-600">Sukces krytyczny — pełne powodzenie, dodatkowy efekt</td></tr>
                <tr><td class="px-4 py-2">≥ połowa kości</td><td class="px-4 py-2 text-green-600">Sukces — akcja udana</td></tr>
                <tr><td class="px-4 py-2">&lt; połowa kości</td><td class="px-4 py-2 text-red-600">Porażka — akcja nieudana</td></tr>
                <tr><td class="px-4 py-2">1</td><td class="px-4 py-2 text-red-600">Krytyczna porażka — komplikacja fabularna</td></tr>
            </tbody>
        </table>
    </div>
</div>
