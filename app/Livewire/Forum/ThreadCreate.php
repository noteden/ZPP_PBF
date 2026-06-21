<?php

namespace App\Livewire\Forum;

use App\Enums\PostTag;
use App\Models\Charakter;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Nowy wątek')]
class ThreadCreate extends Component
{
    public Forum $forum;

    public string $name = '';

    public string $content = '';

    public string $tag = PostTag::Normal->value;

    public ?int $charakter_id = null;

    public function mount(Forum $forum): void
    {
        $forum->load('category');
        abort_if(
            $forum->category->OnlyforGM && !Auth::user()?->isModerator(),
            403
        );
        $this->forum = $forum;
    }

    protected function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
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
    public function characters(): Collection
    {
        return Charakter::where('user_id', Auth::id())->orderBy('name')->get(['id', 'name']);
    }

    public function save(): void
    {
        $this->validate($this->rules());

        if ($this->charakter_id && !Charakter::where('id', $this->charakter_id)->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $thread = Thread::create([
            'name'     => $this->name,
            'user_id'  => Auth::id(),
            'forum_id' => $this->forum->id,
            'tag'      => $this->tag,
        ]);

        Post::create([
            'content'      => $this->content,
            'thread_id'    => $thread->id,
            'user_id'      => Auth::id(),
            'charakter_id' => $this->charakter_id,
            'tag'          => $this->tag,
        ]);

        $this->redirect(route('forum.thread.show', $thread->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.forum.thread-create')->layout('layouts.app');
    }
}
