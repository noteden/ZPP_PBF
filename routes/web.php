<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', \App\Livewire\Messages\Inbox::class)->name('index');
        Route::get('/{partner}', \App\Livewire\Messages\Conversation::class)->name('conversation');
    });

    Route::get('notifications', \App\Livewire\Notifications\NotificationList::class)
        ->name('notifications');

    Route::get('moderation', \App\Livewire\Reports\ModerationPanel::class)
        ->middleware('role:mg,admin')
        ->name('moderation');

    Route::get('activity-log', \App\Livewire\ActivityLog\ActivityLogList::class)
        ->middleware('role:mg,admin')
        ->name('activity-log');
});

require __DIR__.'/settings.php';
