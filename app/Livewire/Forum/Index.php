<?php

namespace App\Livewire\Forum;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forum')]
class Index extends Component
{
    public function getListeners(): array
    {
        return ['echo:forum,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->categories);
    }

    #[Computed]
    public function categories(): Collection
    {
        $isModerator = Auth::user()?->isModerator() ?? false;

        return Category::with(['forums' => function ($q) {
                $q->withCount('threads');
            }])
            ->when(!$isModerator, fn ($q) => $q->where('OnlyforGM', false))
            ->orderBy('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.forum.index')->layout('layouts.app');
    }
}
