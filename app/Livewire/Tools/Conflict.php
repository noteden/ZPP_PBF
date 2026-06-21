<?php

namespace App\Livewire\Tools;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Rozstrzyganie konfliktów')]
class Conflict extends Component
{
    /** Dostępne typy kości. */
    public array $dice = [4, 6, 8, 10, 12, 20, 100];

    public int $sides = 20;

    public int $modifier = 0;

    public ?int $lastRoll = null;

    public ?int $lastTotal = null;

    /** Historia ostatnich rzutów (najnowsze na górze). */
    public array $history = [];

    public function roll(): void
    {
        $roll = random_int(1, $this->sides);
        $total = $roll + $this->modifier;

        $this->lastRoll = $roll;
        $this->lastTotal = $total;

        array_unshift($this->history, [
            'die'      => 'k'.$this->sides,
            'roll'     => $roll,
            'modifier' => $this->modifier,
            'total'    => $total,
            'outcome'  => $this->outcome($this->sides, $roll),
        ]);

        $this->history = array_slice($this->history, 0, 12);
    }

    /** Prosta interpretacja wyniku (sukces krytyczny / porażka). */
    private function outcome(int $sides, int $roll): string
    {
        if ($roll === $sides) {
            return 'Sukces krytyczny';
        }
        if ($roll === 1) {
            return 'Krytyczna porażka';
        }
        if ($roll >= (int) ceil($sides / 2)) {
            return 'Sukces';
        }

        return 'Porażka';
    }

    public function render()
    {
        return view('livewire.tools.conflict')->layout('layouts.app');
    }
}
