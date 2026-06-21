<?php

namespace App\Livewire\Player;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profil gracza')]
class Show extends Component
{
    public User $user;

    public function getListeners(): array
    {
        return ['echo:leaderboard,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        $this->user->loadCount(['posts', 'badges', 'charakters']);
        unset($this->characters, $this->badges);
    }

    public function mount(User $user): void
    {
        $this->user = $user->loadCount(['posts', 'badges', 'charakters']);
    }

    #[Computed]
    public function characters(): Collection
    {
        return $this->user->charakters()->orderByDesc('experience')->get();
    }

    #[Computed]
    public function badges(): Collection
    {
        return $this->user->badges()->get();
    }

    public function render()
    {
        return view('livewire.player.show')->layout('layouts.app');
    }
}
