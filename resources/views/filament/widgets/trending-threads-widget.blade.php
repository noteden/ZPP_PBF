<div class="fi-wi-card p-6 h-full">
    <div class="widget-header flex items-center gap-3">
        <span class="material-symbols-outlined text-[#f2ca50]">local_fire_department</span>
        <h3 class="font-headline text-lg font-bold text-white tracking-wide">Trending</h3>
    </div>

    <div class="space-y-6">
        @forelse($this->getTrending() as $thread)
            <div class="group cursor-pointer">
                <h4 class="font-medium text-[13px] text-gray-200 group-hover:text-[#f2ca50] transition-colors leading-snug line-clamp-2 mb-2">
                    {{ $thread->name }}
                </h4>
                <div class="flex items-center gap-4 text-[10px] text-gray-500 font-bold uppercase tracking-tight">
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px] text-gray-600">forum</span>
                        {{ $thread->posts_count }} posts
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px] text-gray-600">visibility</span>
                        {{ rand(100, 999) }} views
                    </div>
                    
                    <span class="material-symbols-outlined text-[16px] ml-auto text-[#f2ca50] opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">arrow_forward</span>
                </div>
            </div>
        @empty
             <p class="text-gray-500 text-sm italic py-4">No epic tales are unfolding yet...</p>
        @endforelse
    </div>
</div>
