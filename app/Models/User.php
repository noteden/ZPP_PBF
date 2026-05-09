<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    public function missions(): BelongsToMany
    {
        return $this->belongsToMany(Mission::class, 'mission_user_review', 'user_id', 'mission_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(PrivateMessage::class, 'sender_user_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(PrivateMessage::class, 'receiver_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isGameMaster(): bool
    {
        return $this->role === UserRole::GameMaster;
    }

    public function isPlayer(): bool
    {
        return $this->role === UserRole::Player;
    }

    public function isModerator(): bool
    {
        return $this->isAdmin() || $this->isGameMaster();
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user', 'user_id', 'badge_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function getRoleLabel(): string
    {
        return $this->role->label();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
