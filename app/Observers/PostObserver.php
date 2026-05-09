<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\Badge;
use App\Notifications\NewThreadReply;

class PostObserver
{
    public function created(Post $post): void
    {
        ActivityLog::record('created', $post, 'Post dodany przez "' . ($post->user->name ?? '?') . '".');

        $post->thread->load('posts.user');
        $participants = $post->thread->posts
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->reject(fn ($u) => $u->id === $post->user_id);

        foreach ($participants as $user) {
            $user->notify(new NewThreadReply($post));
        }

        $charakter = $post->charakter;
        if (!$charakter || !$charakter->user) return;

        $user = $charakter->user;

        // Sprawdzamy, czy użytkownik MA JUŻ tę odznakę, zamiast liczyć posty.
        // To jest bezpieczniejsze, bo odznaka zostanie przyznana tylko raz w życiu.
        $badge = Badge::where('name', 'Pierwszy Post')->first();

        if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
            // Przyznaj odznakę
            $user->badges()->attach($badge->id);
        }
        dd("Observer działa!", $post->charakter->user->name);

    }

    public function updated(Post $post): void
    {
        ActivityLog::record('updated', $post, 'Post zaktualizowany przez "' . ($post->user->name ?? '?') . '".');
    }

    public function deleted(Post $post): void
    {
        ActivityLog::record('deleted', $post, 'Post usuniety przez "' . (auth()->user()->name ?? '?') . '".');
    }
}
