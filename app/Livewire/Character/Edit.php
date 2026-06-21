<?php

namespace App\Livewire\Character;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Edytuj postać')]
class Edit extends Component
{
    public Charakter $character;

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

    /** Statystyki karty postaci jako lista par [name, value]. */
    public array $stats = [];

    public function mount(Charakter $charakter): void
    {
        abort_unless($charakter->user_id === Auth::id(), 403);

        $this->character = $charakter;
        $this->name      = $charakter->name;
        $this->age       = $charakter->age;
        $this->origin    = $charakter->origin;
        $this->race      = $charakter->race;
        $this->eyes      = $charakter->eyes;
        $this->hair      = $charakter->hair;
        $this->avatar    = $charakter->avatar;
        $this->biography = $charakter->biography;

        $sheet = CharakterSheet::firstOrCreate(
            ['charakter_id' => $charakter->id],
            ['statistic' => []]
        );

        foreach ((array) $sheet->statistic as $key => $value) {
            $this->stats[] = ['name' => (string) $key, 'value' => (string) $value];
        }
    }

    public function addStat(): void
    {
        $this->stats[] = ['name' => '', 'value' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
    }

    public function save(): void
    {
        $this->validate();

        $this->character->update([
            'name'      => $this->name,
            'age'       => $this->age,
            'origin'    => $this->origin,
            'race'      => $this->race,
            'eyes'      => $this->eyes,
            'hair'      => $this->hair,
            'avatar'    => $this->avatar,
            'biography' => $this->biography,
        ]);

        $statistic = [];
        foreach ($this->stats as $stat) {
            $key = trim((string) ($stat['name'] ?? ''));
            if ($key !== '') {
                $statistic[$key] = $stat['value'] ?? '';
            }
        }

        CharakterSheet::updateOrCreate(
            ['charakter_id' => $this->character->id],
            ['statistic' => $statistic]
        );

        $this->redirect(route('character.show', $this->character->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.character.edit')->layout('layouts.app');
    }
}
