<?php

namespace App\Livewire\Character;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Nowa postać')]
class Create extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|integer|min:0|max:9999')]
    public ?int $age = null;

    #[Validate('nullable|string|max:255')]
    public ?string $origin = null;

    #[Validate('nullable|string|max:255')]
    public ?string $race = null;

    #[Validate('nullable|string|max:255')]
    public ?string $eyes = null;

    #[Validate('nullable|string|max:255')]
    public ?string $hair = null;

    #[Validate('nullable|url|max:2048')]
    public ?string $avatar = null;

    #[Validate('nullable|string|max:10000')]
    public ?string $biography = null;

    public function save(): void
    {
        $this->validate();

        $character = Charakter::create([
            'name'      => $this->name,
            'age'       => $this->age,
            'origin'    => $this->origin,
            'race'      => $this->race,
            'eyes'      => $this->eyes,
            'hair'      => $this->hair,
            'avatar'    => $this->avatar,
            'biography' => $this->biography,
            'user_id'   => Auth::id(),
        ]);

        CharakterSheet::create([
            'charakter_id' => $character->id,
            'statistic'    => [],
        ]);

        $this->redirect(route('character.show', $character->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.character.create')->layout('layouts.app');
    }
}
