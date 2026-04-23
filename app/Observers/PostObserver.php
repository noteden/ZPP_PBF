<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Post;
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
