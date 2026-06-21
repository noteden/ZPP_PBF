<?php

namespace App\Livewire\Leaderboard;

use App\Models\Charakter;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ranking')]
class Index extends Component
{
    public string $tab = 'characters';

    public function getListeners(): array
    {
        return ['echo:leaderboard,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->ranking, $this->characters);
    }

    #[Computed]
    public function ranking(): Collection
    {
        return User::query()
            ->withCount(['posts', 'badges'])
            ->orderByDesc('posts_count')
            ->orderByDesc('badges_count')
            ->limit(50)
            ->get();
    }

    #[Computed]
    public function characters(): Collection
    {
        return Charakter::query()
            ->with('user')
            ->orderByDesc('experience')
            ->orderByDesc('history_points')
            ->limit(50)
            ->get();
    }

    public function render()
    {
        return view('livewire.leaderboard.index')->layout('layouts.app');
    }
}
