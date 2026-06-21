<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'proposed_by', 'status'])]
class Mission extends Model
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mission_user_review', 'mission_id', 'user_id')
            ->withPivot(['review', 'rating']);
    }

    public function proposer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }

    /** Średnia ocena misji wystawiona przez role werdyktujące. */
    public function averageRating(): ?float
    {
        $ratings = $this->users()
            ->wherePivotNotNull('rating')
            ->pluck('mission_user_review.rating');

        return $ratings->isEmpty() ? null : round($ratings->avg(), 1);
    }

    public function ratingsCount(): int
    {
        return $this->users()->wherePivotNotNull('rating')->count();
    }
}
