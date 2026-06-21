<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PBF') }} — Gra fabularna Play-by-Forum</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        {{-- Zastosuj zapisany motyw przed renderem (wspólny klucz z aplikacją) --}}
        <script>
            (function () {
                const pref = localStorage.getItem('flux.appearance') || 'system';
                const dark = pref === 'dark' || (pref === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', dark);
            })();
            function togglePbfTheme() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('flux.appearance', isDark ? 'dark' : 'light');
            }
        </script>

        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

        {{-- Tło --}}
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-white via-zinc-50 to-zinc-100 dark:from-zinc-950 dark:via-zinc-900 dark:to-black"></div>
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 h-[500px] w-[800px] rounded-full bg-amber-500/10 blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 h-[400px] w-[400px] rounded-full bg-indigo-500/10 blur-[120px]"></div>
        </div>

        {{-- Nawigacja --}}
        <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
            <div class="flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500/15 text-amber-500 text-lg">⚔️</span>
                <span class="text-lg font-bold tracking-tight">{{ config('app.name', 'PBF') }}</span>
            </div>
            <nav class="flex items-center gap-2 text-sm">
                {{-- Przełącznik motywu --}}
                <button onclick="togglePbfTheme()" type="button" aria-label="Przełącz motyw"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-300 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <span class="hidden dark:inline">☀️</span>
                    <span class="inline dark:hidden">🌙</span>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-amber-500 px-4 py-2 font-semibold text-zinc-950 transition hover:bg-amber-400">Wejdź do gry</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 font-medium text-zinc-600 transition hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white">Zaloguj się</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-amber-500 px-4 py-2 font-semibold text-zinc-950 transition hover:bg-amber-400">Dołącz</a>
                @endauth
            </nav>
        </header>

        {{-- Hero --}}
        <main class="mx-auto max-w-6xl px-6">
            <section class="py-20 text-center sm:py-28">
                <span class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-4 py-1.5 text-xs font-medium uppercase tracking-widest text-amber-600 dark:text-amber-300">
                    Gra fabularna Play-by-Forum
                </span>
                <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-bold leading-tight tracking-tight sm:text-6xl">
                    Twórz <span class="text-amber-500">legendy</span>,<br class="hidden sm:block"> pisz własną historię świata
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">
                    Wciel się w bohatera, rozwijaj jego kartę postaci, prowadź fabularne wątki na forum,
                    bierz udział w misjach i wydarzeniach — wszystko w czasie rzeczywistym.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-xl bg-amber-500 px-7 py-3.5 font-semibold text-zinc-950 shadow-lg shadow-amber-500/20 transition hover:bg-amber-400">Przejdź do panelu</a>
                        <a href="{{ route('forum.index') }}" class="rounded-xl border border-zinc-300 px-7 py-3.5 font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800/50">Otwórz forum</a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-xl bg-amber-500 px-7 py-3.5 font-semibold text-zinc-950 shadow-lg shadow-amber-500/20 transition hover:bg-amber-400">Rozpocznij przygodę</a>
                        <a href="{{ route('login') }}" class="rounded-xl border border-zinc-300 px-7 py-3.5 font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800/50">Mam już konto</a>
                    @endauth
                </div>
            </section>

            {{-- Funkcje --}}
            <section class="grid grid-cols-1 gap-5 pb-24 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $features = [
                        ['🎭', 'Karty postaci', 'Wiele postaci na konto — statystyki, umiejętności i ekwipunek zatwierdzane przez Mistrza Gry.'],
                        ['💬', 'Forum fabularne', 'Wątki i scenariusze w lokacjach świata, cytowanie, tagi i archiwizacja.'],
                        ['🗺️', 'Misje i kampanie', 'Zgłaszaj fabuły, dołączaj do misji i zdobywaj doświadczenie.'],
                        ['📜', 'Kronika świata', 'Historia wydarzeń — wojny, kataklizmy i czyny bohaterów.'],
                        ['🏆', 'Ranking i odznaki', 'Rywalizuj o miejsce w rankingu i zbieraj osiągnięcia.'],
                        ['⚡', 'Czas rzeczywisty', 'Nowe posty, wiadomości i powiadomienia pojawiają się na żywo.'],
                    ];
                @endphp
                @foreach ($features as [$icon, $title, $desc])
                    <div class="group rounded-2xl border border-zinc-200 bg-white/70 p-6 backdrop-blur transition hover:border-amber-500/40 hover:shadow-lg dark:border-zinc-800 dark:bg-zinc-900/50 dark:hover:bg-zinc-900">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-zinc-100 text-2xl transition group-hover:bg-amber-500/15 dark:bg-zinc-800">{{ $icon }}</div>
                        <h3 class="mt-4 text-lg font-semibold">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $desc }}</p>
                    </div>
                @endforeach
            </section>
        </main>

        <footer class="border-t border-zinc-200 py-8 text-center text-sm text-zinc-500 dark:border-zinc-900">
            &copy; {{ now()->year }} {{ config('app.name', 'PBF') }} — gra fabularna Play-by-Forum.
        </footer>
    </body>
</html>
