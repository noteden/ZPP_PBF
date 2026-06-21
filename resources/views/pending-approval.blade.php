<x-layouts::app :title="__('Konto oczekuje na zatwierdzenie')">
    <div class="flex min-h-[70vh] items-center justify-center px-4">
        <div class="max-w-md text-center">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <flux:icon name="clock" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" />
            </div>

            <flux:heading size="xl" class="mb-2">Konto oczekuje na zatwierdzenie</flux:heading>

            <flux:text class="text-zinc-500 dark:text-zinc-400 mb-6">
                Dziękujemy za rejestrację, <strong>{{ auth()->user()->name }}</strong>.
                Twoje konto musi zostać zatwierdzone przez Mistrza Gry lub Administratora,
                zanim uzyskasz dostęp do gry. Wróć później lub skontaktuj się z prowadzącym.
            </flux:text>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button type="submit" variant="ghost" icon="arrow-right-start-on-rectangle">
                    Wyloguj się
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::app>
