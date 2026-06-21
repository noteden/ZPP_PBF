<?php

namespace App\Livewire\Library;

use App\Models\Documents;
use App\Models\Tutorial;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Biblioteka')]
class Index extends Component
{
    public string $tab = 'documents';

    public function getListeners(): array
    {
        return ['echo:library,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->documents, $this->tutorials);
    }

    #[Computed]
    public function documents(): Collection
    {
        return Documents::orderByDesc('created_at')->get();
    }

    #[Computed]
    public function tutorials(): Collection
    {
        return Tutorial::orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('livewire.library.index')->layout('layouts.app');
    }
}
