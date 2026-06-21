<?php

namespace App\Observers;

use App\Events\PostCreated;
use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\Badge;
use App\Models\User;
use App\Notifications\NewThreadReply;

class PostObserver
{
    public function created(Post $post): void
    {
        ActivityLog::record('created', $post, 'Post dodany przez "' . ($post->user->name ?? '?') . '".');

        // Real-time: powiadom subskrybentów wątku o nowym poście.
        PostCreated::dispatch($post);

        // Powiadom pozostałych uczestników wątku o nowej odpowiedzi.
        $participantIds = $post->thread->posts()
            ->where('user_id', '!=', $post->user_id)
            ->distinct()
            ->pluck('user_id');

        User::whereIn('id', $participantIds)->get()
            ->each(fn (User $user) => $user->notify(new NewThreadReply($post)));

        $this->awardFirstPostBadge($post);
    }

    /**
     * Przyznaje odznakę "Pierwszy Post" autorowi postaci (jednorazowo).
     */
    protected function awardFirstPostBadge(Post $post): void
    {
        $user = $post->charakter?->user;
        if (!$user) {
            return;
        }

        $badge = Badge::where('name', Badge::FIRST_POST)->first();

        if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
            $user->badges()->attach($badge->id);
            \App\Events\ResourceChanged::dispatch('badges');
        }
    }

    public function updated(Post $post): void
    {
        ActivityLog::record('updated', $post, 'Post zaktualizowany przez "' . ($post->user->name ?? '?') . '".');
    }

    public function deleted(Post $post): void
    {
        ActivityLog::record('deleted', $post, 'Post usuniety przez "' . (auth()->user()?->name ?? '?') . '".');
    }
}
