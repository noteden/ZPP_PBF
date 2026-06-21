<?php

namespace App\Observers;

use App\Events\CharacterUpdated;
use App\Models\CharakterSheet;
use App\Models\Skill;

class SkillObserver
{
    public function updated(Skill $skill): void
    {
        // Live: MG zatwierdził umiejętność -> odśwież karty postaci, które ją mają.
        CharakterSheet::whereHas('skills', fn ($q) => $q->where('skills.id', $skill->id))
            ->pluck('charakter_id')
            ->each(fn ($charakterId) => CharacterUpdated::dispatch((int) $charakterId));
    }
}
