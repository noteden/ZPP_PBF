<?php

namespace App\Livewire\Character;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Postać')]
class Show extends Component
{
    public Charakter $character;

    public function mount(Charakter $charakter): void
    {
        abort_unless(
            $charakter->user_id === Auth::id() || Auth::user()?->isModerator(),
            403
        );

        $this->loadCharacter($charakter->id);
    }

    /** Nasłuch real-time: zmiana karty (XP/PH, statystyki, akceptacja umiejętności). */
    public function getListeners(): array
    {
        return [
            "echo:character.{$this->character->id},.CharacterUpdated" => 'onCharacterUpdated',
        ];
    }

    public function onCharacterUpdated(): void
    {
        $this->loadCharacter($this->character->id);
    }

    protected function loadCharacter(int $id): void
    {
        $character = Charakter::with([
            'user',
            'sheet.skills',
            'sheet.equipment',
        ])->findOrFail($id);

        $this->character = $character;
    }

    public function render()
    {
        return view('livewire.character.show')->layout('layouts.app');
    }
}
