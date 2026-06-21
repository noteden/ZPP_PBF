<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-o-bolt">
        <x-slot name="heading">Szybkie akcje</x-slot>

        <div class="flex flex-wrap gap-3">
            <x-filament::button
                tag="a"
                :href="\App\Filament\Resources\Threads\ThreadResource::getUrl('create')"
                icon="heroicon-m-pencil-square"
            >
                Nowy wątek
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="\App\Filament\Resources\Charakters\CharakterResource::getUrl('create')"
                icon="heroicon-m-user-plus"
                color="gray"
            >
                Nowa postać
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="\App\Filament\Resources\WorldLogs\WorldLogResource::getUrl('create')"
                icon="heroicon-m-book-open"
                color="gray"
            >
                Wpis kroniki
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="\App\Filament\Resources\Documents\DocumentsResource::getUrl('create')"
                icon="heroicon-m-document-text"
                color="gray"
            >
                Dokument
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
