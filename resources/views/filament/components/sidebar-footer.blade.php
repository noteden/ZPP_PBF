<div class="mt-auto px-4 pb-6 space-y-4 border-t border-white/10 pt-6" x-data="{ open: false, roll: 0, status: '' }">
    <!-- Roll Initiative Button -->
    <button 
        @click="rollValue = Math.floor(Math.random() * 20) + 1; roll = rollValue; status = rollValue === 20 ? 'success' : (rollValue === 1 ? 'critical' : 'normal'); open = true"
        class="w-full py-3 px-4 bg-gradient-to-r from-[#f2ca50] to-[#d4af37] text-[#3c2f00] rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-[0_4px_12px_rgba(242,202,80,0.2)]"
    >
        <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">casino</span>
        Roll Initiative
    </button>

    <!-- Logout Button -->
    <form action="{{ filament()->getLogoutUrl() }}" method="post" class="w-full">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-[#e5e2e1]/70 hover:text-red-400 hover:bg-red-400/5 transition-colors duration-300 group">
            <span class="material-symbols-outlined text-lg group-hover:rotate-12 transition-transform">logout</span>
            <span class="font-medium tracking-wide">Log Out</span>
        </button>
    </form>

    <!-- ROLL MODAL -->
    <template x-teleport="body">
        <div 
            x-show="open" 
            x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md"
            style="display: none;"
        >
            <div 
                @click.away="open = false"
                class="relative p-10 bg-[#131313] border-2 rounded-3xl text-center shadow-[0_0_50px_rgba(242,202,80,0.2)] max-w-sm w-full mx-4 overflow-hidden"
                :class="{ 'border-[#f2ca50]': status !== 'critical', 'border-red-600': status === 'critical' }"
            >
                <!-- Decorative background -->
                <div class="absolute inset-0 bg-gradient-to-b from-[#f2ca50]/5 to-transparent pointer-events-none"></div>

                <div class="relative z-10">
                    <h3 class="text-gray-400 uppercase tracking-widest text-xs font-bold mb-2">Initiative Roll</h3>
                    
                    <div class="flex flex-col items-center justify-center my-6">
                        <div 
                            class="text-7xl font-headline font-bold mb-2"
                            :class="{ 'text-[#f2ca50] drop-shadow-[0_0_15px_rgba(242,202,80,0.5)]': status === 'success', 'text-red-600': status === 'critical', 'text-white': status === 'normal' }"
                            x-text="roll"
                        ></div>
                        
                        <p class="text-sm font-medium" :class="{ 'text-amber-300': status === 'success', 'text-red-400': status === 'critical', 'text-gray-400': status === 'normal' }">
                            <span x-show="status === 'success'">✨ CRITICAL SUCCESS ✨</span>
                            <span x-show="status === 'critical'">💀 CRITICAL FAILURE 💀</span>
                            <span x-show="status === 'normal'">Turn order determined</span>
                        </p>
                    </div>

                    <button 
                        @click="open = false"
                        class="mt-4 px-6 py-2 bg-white/5 border border-white/10 hover:bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest transition-all"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
