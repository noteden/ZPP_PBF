<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Wydarzenia')]
class Index extends Component
{
    public bool $showModal = false;

    public function getListeners(): array
    {
        return ['echo:events,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->upcoming, $this->past);
    }

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:5000')]
    public string $description = '';

    #[Validate('required|string|max:100')]
    public string $type = 'sesja';

    #[Validate('required|date')]
    public string $date = '';

    #[Computed]
    public function upcoming(): Collection
    {
        return Event::with('user')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();
    }

    #[Computed]
    public function past(): Collection
    {
        return Event::with('user')
            ->where('date', '<', now())
            ->orderByDesc('date')
            ->limit(20)
            ->get();
    }

    public function save(): void
    {
        $this->validate();

        Event::create([
            'name'        => $this->name,
            'description' => $this->description,
            'type'        => $this->type,
            'date'        => $this->date,
            'user_id'     => Auth::id(),
        ]);

        $this->reset(['name', 'description', 'type', 'date']);
        $this->type = 'sesja';
        $this->showModal = false;

        unset($this->upcoming, $this->past);
    }

    public function delete(int $id): void
    {
        $event = Event::findOrFail($id);
        if ($event->user_id === Auth::id() || Auth::user()?->isModerator()) {
            $event->delete();
            unset($this->upcoming, $this->past);
        }
    }

    public function render()
    {
        return view('livewire.events.index')->layout('layouts.app');
    }
}
