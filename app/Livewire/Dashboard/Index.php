<?php

namespace App\Livewire\Dashboard;

use App\Models\Charakter;
use App\Models\Event;
use App\Models\Mission;
use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Index extends Component
{
    public function getListeners(): array
    {
        return [
            'echo:forum,.ResourceChanged' => 'refreshFeed',
            'echo:activity,.ResourceChanged' => 'refreshFeed',
            'echo:leaderboard,.ResourceChanged' => 'refreshFeed',
            'echo:events,.ResourceChanged' => 'refreshFeed',
            'echo:missions,.ResourceChanged' => 'refreshFeed',
        ];
    }

    public function refreshFeed(): void
    {
        unset($this->stats, $this->recentPosts, $this->trending, $this->upcomingEvents, $this->myCharacters);
    }

    #[Computed]
    public function stats(): array
    {
        return [
            ['label' => 'Gracze',   'value' => User::where('approved', true)->count(), 'icon' => 'users',                  'route' => route('leaderboard.index')],
            ['label' => 'Postacie', 'value' => Charakter::count(),                      'icon' => 'user-group',             'route' => route('character.index')],
            ['label' => 'Posty',    'value' => Post::count(),                           'icon' => 'chat-bubble-left-right', 'route' => route('forum.index')],
            ['label' => 'Misje',    'value' => Mission::count(),                        'icon' => 'map',                    'route' => route('missions.index')],
        ];
    }

    #[Computed]
    public function recentPosts(): Collection
    {
        return Post::with(['user', 'thread', 'charakter'])->latest()->limit(5)->get();
    }

    #[Computed]
    public function trending(): Collection
    {
        return Thread::withCount('posts')->where('archived', false)
            ->orderByDesc('posts_count')->limit(4)->get();
    }

    #[Computed]
    public function upcomingEvents(): Collection
    {
        return Event::where('date', '>=', now())->orderBy('date')->limit(4)->get();
    }

    #[Computed]
    public function myCharacters(): Collection
    {
        return Auth::user()->charakters()->orderByDesc('experience')->limit(3)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}
