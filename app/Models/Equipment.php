<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'weight', 'statistic', 'type'])]
class Equipment extends Model
{
    use HasFactory;

    public function charakterSheets(): BelongsToMany
    {
        return $this->belongsToMany(CharakterSheet::class, 'charakter_sheet_equipment', 'equipment_id', 'charakter_sheet_id');
    }

    protected function casts(): array
    {
        return [
            'statistic' => 'array',
        ];
    }
}
