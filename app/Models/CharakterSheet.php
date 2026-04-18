<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['statistic', 'charakter_id'])]
class CharakterSheet extends Model
{
    use HasFactory;

    public function charakter(): BelongsTo
    {
        return $this->belongsTo(Charakter::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'charakter_sheet_skill', 'charakter_sheet_id', 'skill_id');
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'charakter_sheet_equipment', 'charakter_sheet_id', 'equipment_id');
    }

    protected function casts(): array
    {
        return [
            'statistic' => 'array',
        ];
    }
}
