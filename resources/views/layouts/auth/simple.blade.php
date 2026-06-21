<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {{-- Ekrany auth są zawsze ciemne (styl fantasy) — wymuś tryb dark, by tekst Flux był jasny. --}}
        <script>document.documentElement.classList.add('dark');</script>
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">

        {{-- Tło w stylu strony głównej --}}
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-zinc-950 via-zinc-900 to-black"></div>
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 h-[500px] w-[800px] rounded-full bg-amber-500/10 blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 h-[400px] w-[400px] rounded-full bg-indigo-600/10 blur-[120px]"></div>
        </div>

        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-6">
                {{-- Logo / marka --}}
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/15 text-2xl">⚔️</span>
                    <span class="text-lg font-bold tracking-tight">{{ config('app.name', 'PBF') }}</span>
                    <span class="text-xs uppercase tracking-widest text-amber-300/80">Play-by-Forum</span>
                </a>

                {{-- Karta z formularzem --}}
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-6 shadow-xl shadow-black/30 backdrop-blur sm:p-8">
                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
