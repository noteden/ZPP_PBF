<?php

namespace App\Models;

use App\Enums\PostTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'user_id', 'forum_id', 'charakter_id', 'tag'])]
class Thread extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return ['tag' => PostTag::class];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forum(): BelongsTo
    {
        return $this->belongsTo(Forum::class);
    }

    public function charakter(): BelongsTo
    {
        return $this->belongsTo(Charakter::class);
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
