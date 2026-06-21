<?php

namespace App\Livewire\Character;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use App\Models\Equipment;
use App\Models\Skill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Karta postaci')]
class Skills extends Component
{
    public Charakter $character;
    public CharakterSheet $sheet;

    #[Validate('required|string|max:255')]
    public string $skillName = '';

    #[Validate('nullable|string|max:2000')]
    public ?string $skillDescription = null;

    #[Validate('required|string|max:255')]
    public string $equipmentName = '';

    #[Validate('nullable|string|max:2000')]
    public ?string $equipmentDescription = null;

    /** Nasłuch real-time: zmiany na karcie (np. MG zatwierdził umiejętność). */
    public function getListeners(): array
    {
        return [
            "echo:character.{$this->character->id},.CharacterUpdated" => 'onCharacterUpdated',
        ];
    }

    public function onCharacterUpdated(): void
    {
        unset($this->skills, $this->equipment);
    }

    public function mount(Charakter $charakter): void
    {
        abort_unless($charakter->user_id === Auth::id(), 403);

        $this->character = $charakter;
        $this->sheet = CharakterSheet::firstOrCreate(
            ['charakter_id' => $charakter->id],
            ['statistic' => []]
        );
    }

    #[Computed]
    public function skills(): Collection
    {
        return $this->sheet->skills()->get();
    }

    #[Computed]
    public function equipment(): Collection
    {
        return $this->sheet->equipment()->get();
    }

    public function submit(): void
    {
        $this->validate([
            'skillName'        => 'required|string|max:255',
            'skillDescription' => 'nullable|string|max:2000',
        ]);

        $skill = Skill::create([
            'name'        => $this->skillName,
            'description' => $this->skillDescription ?? '',
            'accepted'    => false,
        ]);

        $this->sheet->skills()->attach($skill->id, ['level' => 1]);

        $this->reset(['skillName', 'skillDescription']);
        unset($this->skills);
    }

    public function addEquipment(): void
    {
        $this->validate([
            'equipmentName'        => 'required|string|max:255',
            'equipmentDescription' => 'nullable|string|max:2000',
        ]);

        $item = Equipment::create([
            'name'        => $this->equipmentName,
            'description' => $this->equipmentDescription ?? '',
            'weight'      => 0,
            'statistic'   => [],
            'type'        => 'inne',
        ]);

        $this->sheet->equipment()->attach($item->id, ['number' => 1, 'is_equipped' => false]);

        $this->reset(['equipmentName', 'equipmentDescription']);
        unset($this->equipment);
    }

    public function removeEquipment(int $equipmentId): void
    {
        $this->sheet->equipment()->detach($equipmentId);
        unset($this->equipment);
    }

    public function render()
    {
        return view('livewire.character.skills')->layout('layouts.app');
    }
}
