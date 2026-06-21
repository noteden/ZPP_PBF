<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'content', 'published_add', 'file_path', 'category'])]
class Documents extends Model
{
    use HasFactory;
}
