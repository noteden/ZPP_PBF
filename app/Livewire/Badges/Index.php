<?php

namespace App\Livewire\Badges;

use App\Models\Badge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Odznaki')]
class Index extends Component
{
    public function getListeners(): array
    {
        return ['echo:badges,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->allBadges, $this->myBadgeIds);
    }

    #[Computed]
    public function allBadges(): Collection
    {
        return Badge::orderBy('name')->get();
    }

    #[Computed]
    public function myBadgeIds(): array
    {
        return Auth::user()?->badges()->pluck('badges.id')->toArray() ?? [];
    }

    public function render()
    {
        return view('livewire.badges.index')->layout('layouts.app');
    }
}
