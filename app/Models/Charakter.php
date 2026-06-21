<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'age', 'origin', 'race', 'eyes', 'hair', 'avatar', 'biography', 'experience', 'history_points', 'user_id'])]
class Charakter extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'experience'     => 'integer',
            'history_points' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sheet(): HasOne
    {
        return $this->hasOne(CharakterSheet::class);
    }
}
