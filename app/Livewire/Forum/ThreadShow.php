<?php

namespace App\Livewire\Forum;

use App\Enums\PostTag;
use App\Models\Charakter;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Wątek')]
class ThreadShow extends Component
{
    use WithPagination;

    public Thread $thread;

    public string $content = '';

    public string $tag = PostTag::Normal->value;

    public ?int $charakter_id = null;

    public ?int $quotedPostId = null;

    /** Nasłuch real-time: nowy post w tym wątku. */
    public function getListeners(): array
    {
        return [
            "echo:thread.{$this->thread->id},.PostCreated" => 'onPostCreated',
        ];
    }

    public function onPostCreated(): void
    {
        // Odśwież listę postów (computed) — nowy post pojawi się na żywo.
        unset($this->posts);
    }

    public function mount(Thread $thread): void
    {
        $thread->load(['forum.category', 'user']);
        abort_if(
            $thread->forum->category->OnlyforGM && !Auth::user()?->isModerator(),
            403
        );
        $this->thread = $thread;
    }

    protected function rules(): array
    {
        return [
            'content'      => 'required|string|max:10000',
            'tag'          => 'required|'.PostTag::validationRule(),
            'charakter_id' => [
                'nullable',
                'integer',
                Rule::exists('charakters', 'id')->where('user_id', Auth::id()),
            ],
        ];
    }

    #[Computed]
    public function posts()
    {
        return $this->thread
            ->posts()
            ->with(['user', 'charakter', 'quotedPosts.user', 'quotedPosts.charakter'])
            ->orderBy('created_at')
            ->paginate(20);
    }

    #[Computed]
    public function characters(): Collection
    {
        return Charakter::where('user_id', Auth::id())->orderBy('name')->get(['id', 'name']);
    }

    public function quote(int $postId): void
    {
        $this->quotedPostId = $postId;
        $this->dispatch('focus-reply');
    }

    public function clearQuote(): void
    {
        $this->quotedPostId = null;
    }

    public function toggleArchive(): void
    {
        abort_unless(Auth::user()?->isModerator(), 403);

        $this->thread->update(['archived' => !$this->thread->archived]);
    }

    public function reply(): void
    {
        $this->validate($this->rules());

        if ($this->charakter_id && !Charakter::where('id', $this->charakter_id)->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $post = Post::create([
            'content'      => $this->content,
            'thread_id'    => $this->thread->id,
            'user_id'      => Auth::id(),
            'charakter_id' => $this->charakter_id,
            'tag'          => $this->tag,
        ]);

        if ($this->quotedPostId) {
            $post->quotedPosts()->attach($this->quotedPostId);
        }

        $this->thread->touch();

        $this->reset(['content', 'quotedPostId']);
        $this->tag = PostTag::Normal->value;
        unset($this->posts);
    }

    public function render()
    {
        return view('livewire.forum.thread-show')->layout('layouts.app');
    }
}
