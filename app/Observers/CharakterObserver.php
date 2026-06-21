<?php

namespace App\Observers;

use App\Events\CharacterUpdated;
use App\Events\ResourceChanged;
use App\Models\Charakter;

class CharakterObserver
{
    public function updated(Charakter $charakter): void
    {
        // Live: np. MG przyznał XP/PH lub zmieniono opis postaci.
        CharacterUpdated::dispatch($charakter->id);
        // Live: ranking (XP) odświeża się na żywo.
        ResourceChanged::dispatch('leaderboard');
    }

    public function created(Charakter $charakter): void
    {
        ResourceChanged::dispatch('leaderboard');
    }
}
