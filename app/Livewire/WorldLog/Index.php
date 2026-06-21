<?php

namespace App\Livewire\WorldLog;

use App\Models\WorldLog;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kronika świata')]
class Index extends Component
{
    public function getListeners(): array
    {
        return ['echo:world-logs,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->logs);
    }

    #[Computed]
    public function logs(): Collection
    {
        return WorldLog::with('user')
            ->orderByDesc('occurred_on')
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.world-log.index')->layout('layouts.app');
    }
}
