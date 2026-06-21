<div class="fi-wi-card p-6 h-full flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-[#f2ca50] text-sm">campaign</span>
            <h3 class="font-label text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Active Quests</h3>
        </div>
        
        <div class="text-6xl font-headline text-[#f2ca50] py-2">
            {{ $missionsCount }}
        </div>
    </div>

    <div class="flex justify-between items-end mt-8 pt-4 border-t border-white/5">
        <div class="flex flex-col">
            <span class="text-[10px] text-gray-600 uppercase font-bold tracking-widest">Total Scribes</span>
            <span class="text-lg text-white font-bold">{{ $usersCount }}</span>
        </div>
        <div class="relative group cursor-help">
            <span class="material-symbols-outlined text-[#f2ca50]/40 text-4xl group-hover:text-[#f2ca50] transition-colors">task_alt</span>
            <div class="absolute bottom-full right-0 mb-2 w-32 hidden group-hover:block bg-[#1c1b1b] border border-[#f2ca50]/20 p-2 rounded shadow-xl pointer-events-none">
                <p class="text-[9px] text-gray-400 leading-tight">All systems operational in the Realm.</p>
            </div>
        </div>
    </div>
</div>
