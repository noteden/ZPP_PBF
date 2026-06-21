<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Strona dla kont oczekujących na zatwierdzenie (poza bramką 'approved').
Route::view('pending-approval', 'pending-approval')
    ->middleware(['auth'])
    ->name('pending-approval');

Route::middleware(['auth', 'verified', 'approved'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard\Index::class)->name('dashboard');

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', \App\Livewire\Messages\Inbox::class)->name('index');
        Route::get('/{partner}', \App\Livewire\Messages\Conversation::class)->name('conversation');
    });

    Route::get('notifications', \App\Livewire\Notifications\NotificationList::class)
        ->name('notifications');

    // Forum
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', \App\Livewire\Forum\Index::class)->name('index');
        Route::get('/forums/{forum}', \App\Livewire\Forum\ForumShow::class)->name('show');
        Route::get('/forums/{forum}/threads/create', \App\Livewire\Forum\ThreadCreate::class)->name('thread.create');
        Route::get('/threads/{thread}', \App\Livewire\Forum\ThreadShow::class)->name('thread.show');
    });

    // Characters
    Route::prefix('characters')->name('character.')->group(function () {
        Route::get('/', \App\Livewire\Character\Index::class)->name('index');
        Route::get('/new', \App\Livewire\Character\Create::class)->name('create');
        Route::get('/{charakter}', \App\Livewire\Character\Show::class)->name('show');
        Route::get('/{charakter}/edit', \App\Livewire\Character\Edit::class)->name('edit');
        Route::get('/{charakter}/skills', \App\Livewire\Character\Skills::class)->name('skills');
    });

    Route::get('missions',   \App\Livewire\Missions\Index::class)->name('missions.index');
    Route::get('events',     \App\Livewire\Events\Index::class)->name('events.index');
    Route::get('world-logs', \App\Livewire\WorldLog\Index::class)->name('world-logs.index');
    Route::get('badges',      \App\Livewire\Badges\Index::class)->name('badges.index');
    Route::get('leaderboard', \App\Livewire\Leaderboard\Index::class)->name('leaderboard.index');
    Route::get('suggestions',\App\Livewire\Suggestions\Index::class)->name('suggestions.index');
    Route::get('library',    \App\Livewire\Library\Index::class)->name('library.index');
    Route::get('tools/conflict', \App\Livewire\Tools\Conflict::class)->name('tools.conflict');

    Route::get('players/{user}', \App\Livewire\Player\Show::class)->name('player.show');

    Route::get('moderation', \App\Livewire\Reports\ModerationPanel::class)
        ->middleware('role:mg,admin')
        ->name('moderation');

    Route::get('activity-log', \App\Livewire\ActivityLog\ActivityLogList::class)
        ->middleware('role:mg,admin')
        ->name('activity-log');
});

require __DIR__.'/settings.php';
