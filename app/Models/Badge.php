<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['name', 'description', 'icon'])]
class Badge extends Model
{
    use HasFactory;

    /** Nazwa odznaki przyznawanej automatycznie za pierwszy post postacią. */
    public const FIRST_POST = 'Pierwszy Post';

    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user', 'badge_id', 'user_id');
    }
}
