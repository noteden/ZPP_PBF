<?php

namespace App\Observers;

use App\Events\CharacterUpdated;
use App\Models\CharakterSheet;

class CharakterSheetObserver
{
    public function saved(CharakterSheet $sheet): void
    {
        // Live: zmiana statystyk na karcie.
        if ($sheet->charakter_id) {
            CharacterUpdated::dispatch((int) $sheet->charakter_id);
        }
    }
}
