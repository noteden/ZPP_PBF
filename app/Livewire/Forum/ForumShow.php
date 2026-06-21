<?php

namespace App\Livewire\Forum;

use App\Models\Forum;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Forum')]
class ForumShow extends Component
{
    use WithPagination;

    public Forum $forum;

    #[Url(as: 'q')]
    public string $search = '';

    public bool $showArchived = false;

    public function getListeners(): array
    {
        return ["echo:forum.{$this->forum->id},.ResourceChanged" => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->threads);
    }

    public function mount(Forum $forum): void
    {
        $forum->load('category');
        abort_if(
            $forum->category->OnlyforGM && !Auth::user()?->isModerator(),
            403
        );
        $this->forum = $forum;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedShowArchived(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function threads()
    {
        return $this->forum
            ->threads()
            ->with('user')
            ->withCount('posts')
            ->when(!$this->showArchived, fn ($q) => $q->where('archived', false))
            ->when($this->search !== '', function ($q) {
                $term = '%'.$this->search.'%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhereHas('posts', fn ($p) => $p->where('content', 'like', $term));
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.forum.forum-show')->layout('layouts.app');
    }
}
