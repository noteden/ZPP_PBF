<div class="fi-wi-card p-6 h-full">
    <div class="widget-header flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[#f2ca50]">history</span>
            <h3 class="font-headline text-lg font-bold text-white tracking-wide">Recent Activity</h3>
        </div>
        <a href="#" class="text-xs text-[#f2ca50]/60 hover:text-[#f2ca50] transition-colors uppercase tracking-widest font-bold">
            View All
        </a>
    </div>

    <div class="space-y-4">
        @forelse($this->getActivities() as $post)
            <div class="flex gap-4 p-3 rounded-lg hover:bg-white/5 transition-all duration-300 group">
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-[#1c1b1b] border border-white/10 flex items-center justify-center overflow-hidden">
                        @if($post->user->avatar_url)
                             <img src="{{ $post->user->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                             <span class="text-[#f2ca50] font-bold text-lg uppercase">{{ substr($post->user->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-medium text-white group-hover:text-[#f2ca50] transition-colors truncate pr-4">
                            {{ $post->thread->name ?? 'Unknown Thread' }}
                        </h4>
                        <span class="text-[10px] text-gray-500 whitespace-nowrap uppercase font-bold tracking-tighter">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-gray-500">
                            by <strong class="text-gray-300 hover:text-[#f2ca50] cursor-pointer">{{ $post->user->name }}</strong>
                        </span>
                        
                        @if($post->charakter)
                            <span class="px-2 py-0.5 rounded-full bg-[#f2ca50]/10 text-[#f2ca50] text-[10px] font-bold uppercase tracking-wider border border-[#f2ca50]/20">
                                {{ $post->charakter->name }}
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 text-[10px] font-bold uppercase tracking-wider border border-blue-500/20">
                                OOC
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-8 text-center bg-white/5 rounded-xl border border-dashed border-white/10">
                <span class="material-symbols-outlined text-4xl text-gray-600 mb-2">auto_stories</span>
                <p class="text-gray-500 text-sm italic">The chronicle remains silent... for now.</p>
            </div>
        @endforelse
    </div>
</div>
