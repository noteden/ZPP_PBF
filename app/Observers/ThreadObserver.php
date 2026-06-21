<?php

namespace App\Observers;

use App\Events\ResourceChanged;
use App\Models\ActivityLog;
use App\Models\Thread;

class ThreadObserver
{
    public function created(Thread $thread): void
    {
        ActivityLog::record('created', $thread, 'Watek utworzony przez "' . ($thread->user->name ?? '?') . '".');
        $this->broadcastForum($thread);
    }

    public function updated(Thread $thread): void
    {
        ActivityLog::record('updated', $thread, 'Watek zaktualizowany przez "' . ($thread->user->name ?? '?') . '".');
        $this->broadcastForum($thread);
    }

    public function deleted(Thread $thread): void
    {
        ActivityLog::record('deleted', $thread, 'Watek usuniety przez "' . (auth()->user()?->name ?? '?') . '".');
        $this->broadcastForum($thread);
    }

    /** Live: lista wątków w dziale oraz lista działów. */
    protected function broadcastForum(Thread $thread): void
    {
        ResourceChanged::dispatch('forum.'.$thread->forum_id);
        ResourceChanged::dispatch('forum');
    }
}
