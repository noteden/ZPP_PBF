<?php

namespace App\Livewire\Character;

use App\Models\Charakter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Moje postacie')]
class Index extends Component
{
    #[Computed]
    public function characters(): Collection
    {
        return Charakter::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.character.index')->layout('layouts.app');
    }
}
