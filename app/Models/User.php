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

#[Fillable(['name', 'email', 'password', 'role', 'approved', 'last_seen_at'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** Próg (w minutach) uznania użytkownika za online. */
    public const ONLINE_THRESHOLD_MINUTES = 5;

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

    public function isApproved(): bool
    {
        // Każde konto (także MG zgłoszony przy rejestracji) wymaga zatwierdzenia.
        return (bool) $this->approved;
    }

    public function isOnline(): bool
    {
        return $this->last_seen_at !== null
            && $this->last_seen_at->gt(now()->subMinutes(self::ONLINE_THRESHOLD_MINUTES));
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user', 'user_id', 'badge_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function charakters(): HasMany
    {
        return $this->hasMany(Charakter::class);
    }

    public function getRoleLabel(): string
    {
        return $this->role->label();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen_at'      => 'datetime',
            'approved'          => 'boolean',
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
