<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'accepted', 'description'])]
class Skill extends Model
{
    use HasFactory;

    public function charakterSheets(): BelongsToMany
    {
        return $this->belongsToMany(CharakterSheet::class, 'charakter_sheet_skill', 'skill_id', 'charakter_sheet_id');
    }

    protected function casts(): array
    {
        return [
            'accepted' => 'boolean',
        ];
    }
}
