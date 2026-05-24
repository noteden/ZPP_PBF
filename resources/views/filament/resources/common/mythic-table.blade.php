<div class="space-y-4">
    {{-- Header Row - Hidden on mobile, visible on MD+ --}}
    <div class="hidden md:grid grid-cols-12 gap-6 px-8 py-4 border-b border-white/5 text-[11px] font-bold text-mythic-muted uppercase tracking-widest font-body bg-black/20 rounded-t-xl">
        @foreach($headers as $header)
            <div class="{{ $header['width'] ?? 'col-span-3' }}">
                {{ $header['label'] }}
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-3">
        @forelse ($records as $record)
            <div class="mythic-dust-effect grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6 px-6 md:px-8 py-5 items-center bg-[#1A1A1A] md:bg-transparent border border-[#232323] md:border-0 md:border-b md:border-white/5 hover:bg-mythic-gold-muted/5 transition-all duration-300 group relative rounded-2xl md:rounded-none shadow-sm md:shadow-none"
                 wire:loading.class.delay="opacity-50 pointer-events-none">
                
                @foreach($headers as $header)
                    <div class="{{ $header['width'] ?? 'col-span-12 md:col-span-3' }}">
                        {{-- Mobile Label --}}
                        <div class="md:hidden text-[10px] font-bold text-mythic-gold/40 uppercase mb-1 tracking-tighter">{{ $header['label'] }}</div>

                        @if($loop->first)
                            {{-- First Column with Icon and Special Styling --}}
                            <div class="flex items-center gap-4">
                                <div class="bg-black/40 p-2.5 rounded-xl border border-mythic-border/30 group-hover:border-mythic-gold/50 transition-all shadow-inner">
                                    <span class="material-symbols-outlined text-mythic-muted group-hover:text-mythic-gold transition-colors text-2xl">
                                        {{ $record->icon ?? ($header['icon'] ?? 'bookmark') }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-mythic-text font-body text-sm group-hover:text-mythic-gold transition-colors">
                                        {{ data_get($record, $header['field']) }}
                                    </div>
                                    @if(isset($header['subfield']))
                                        <div class="text-[11px] text-mythic-muted mt-1 font-medium italic">
                                            {{ data_get($record, $header['subfield']) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            {{-- Standard Columns --}}
                            <div class="text-[13px] text-mythic-muted leading-relaxed">
                                @if(isset($header['type']) && $header['type'] === 'toggle')
                                    <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                        <input 
                                            @checked(data_get($record, $header['field']))
                                            wire:click="toggleBoolean('{{ $record->id }}', '{{ $header['field'] }}')"
                                            class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-[#2A2A2A] appearance-none cursor-pointer z-10 top-0.5 left-0.5 transition-transform duration-200 ease-in-out {{ data_get($record, $header['field']) ? 'translate-x-4' : '' }}" 
                                            type="checkbox"
                                        />
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-[#2A2A2A] cursor-pointer"></label>
                                    </div>
                                @else
                                    @php
                                        $value = data_get($record, $header['field']);
                                    @endphp
                                    
                                    <div class="line-clamp-2">
                                        @if(is_array($value))
                                            {{ collect($value)->map(fn($v, $k) => "$k: $v")->implode(', ') }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Hover Actions (Edit/Delete) --}}
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 md:pr-8 gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto">
                    <a href="{{ $this->getResource()::getUrl('edit', ['record' => $record]) }}" 
                       class="w-10 h-10 bg-[#222] rounded-full flex items-center justify-center text-mythic-gold border border-white/5 hover:border-mythic-gold/50 hover:bg-mythic-gold/10 transition-all shadow-2xl">
                        <span class="material-symbols-outlined text-[1.25rem]">edit</span>
                    </a>
                    <button 
                        wire:click="mountTableAction('delete', '{{ $record->id }}')"
                        class="w-10 h-10 bg-[#222] rounded-full flex items-center justify-center text-mythic-red border border-white/5 hover:border-mythic-red/50 hover:bg-mythic-red/10 transition-all shadow-2xl">
                        <span class="material-symbols-outlined text-[1.25rem]">delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center p-16 bg-black/20 border border-dashed border-white/5 rounded-3xl text-center">
                <div class="w-20 h-20 bg-[#1A1A1A] rounded-full flex items-center justify-center mb-6 text-mythic-gold/20 shadow-inner">
                    <span class="material-symbols-outlined text-4xl">inventory_2</span>
                </div>
                <div class="text-white font-bold text-xl tracking-tight">No records discovered</div>
                <div class="text-mythic-muted text-sm mt-2 max-w-xs mx-auto">This area of the archives appears to be empty. Try refining your search or create a new entry.</div>
            </div>
        @endforelse
    </div>
</div>
