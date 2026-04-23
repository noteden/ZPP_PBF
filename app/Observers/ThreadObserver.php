<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Thread;

class ThreadObserver
{
    public function created(Thread $thread): void
    {
        ActivityLog::record('created', $thread, 'Watek utworzony przez "' . ($thread->user->name ?? '?') . '".');
    }

    public function updated(Thread $thread): void
    {
        ActivityLog::record('updated', $thread, 'Watek zaktualizowany przez "' . ($thread->user->name ?? '?') . '".');
    }

    public function deleted(Thread $thread): void
    {
        ActivityLog::record('deleted', $thread, 'Watek usuniety przez "' . (auth()->user()->name ?? '?') . '".');
    }
}
