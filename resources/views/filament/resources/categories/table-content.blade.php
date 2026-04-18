<div class="flex-1">
    <div class="min-w-[800px] w-full flex flex-col bg-transparent">
        <!-- Legend/Headers -->
        <div class="grid grid-cols-12 gap-6 px-8 py-4 border-b border-white/5 text-[11px] font-bold text-mythic-muted uppercase tracking-widest font-body bg-black/20">
            <div class="col-span-5 flex items-center gap-1">NAME</div>
            <div class="col-span-4">DESCRIPTION</div>
            <div class="col-span-3">ONLY FOR GM</div>
        </div>

        <!-- Data Rows -->
        @foreach ($records as $record)
            <div class="grid grid-cols-12 gap-6 px-8 py-5 items-center border-b border-white/5 hover:bg-mythic-gold-muted/5 transition-colors duration-200 group relative">
                <!-- Name & Icon -->
                <div class="col-span-5 flex items-center gap-4">
                    <div class="bg-black/40 p-2 rounded-lg border border-mythic-border/30 group-hover:border-mythic-gold/50 transition-all">
                        <span class="material-symbols-outlined text-mythic-muted group-hover:text-mythic-gold transition-colors text-xl">
                            {{ $record->icon ?? 'menu_book' }}
                        </span>
                    </div>
                    <div>
                        <div class="font-bold text-mythic-text font-body text-sm group-hover:text-mythic-gold transition-colors">{{ $record->name }}</div>
                        <div class="text-[13px] text-mythic-muted mt-1">Updated {{ $record->updated_at?->diffForHumans() ?? 'long ago' }}</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-span-4 text-[13px] text-mythic-muted truncate">
                    {{ $record->description }}
                </div>

                <!-- Toggle & Actions -->
                <div class="col-span-3 flex items-center justify-between">
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input 
                            @checked($record->OnlyforGM)
                            wire:click="toggleOnlyForGM('{{ $record->id }}')"
                            class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-[#2A2A2A] appearance-none cursor-pointer z-10 top-0.5 left-0.5 transition-transform duration-200 ease-in-out {{ $record->OnlyforGM ? 'translate-x-4' : '' }}" 
                            type="checkbox"
                        />
                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-[#2A2A2A] cursor-pointer"></label>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ $this->getResource()::getUrl('edit', ['record' => $record]) }}" class="text-mythic-gold hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[1.25rem]">edit</span>
                        </a>
                        <button 
                            wire:click="mountTableAction('delete', '{{ $record->id }}')"
                            class="text-mythic-red hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[1.25rem]">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($records->isEmpty())
            <div class="p-12 text-center text-mythic-muted font-body">
                No categories found matching your criteria.
            </div>
        @endif
    </div>
</div>
