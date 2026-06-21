<?php

namespace App\Livewire\Suggestions;

use App\Models\Suggestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Sugestie')]
class Index extends Component
{
    public function getListeners(): array
    {
        return ['echo:suggestions,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->mySuggestions);
    }

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:5000')]
    public string $content = '';

    #[Computed]
    public function mySuggestions(): Collection
    {
        return Suggestion::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
    }

    public function save(): void
    {
        $this->validate();

        Suggestion::create([
            'name'    => $this->name,
            'content' => $this->content,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['name', 'content']);
        unset($this->mySuggestions);
    }

    public function render()
    {
        return view('livewire.suggestions.index')->layout('layouts.app');
    }
}
