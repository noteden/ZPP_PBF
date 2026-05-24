<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'OnlyforGM'])]
class Category extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'OnlyforGM' => 'boolean',
        ];
    }

    public function forums(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Forum::class);
    }
}
