<?php

namespace App\Livewire\Reports;

use App\Models\Post;
use App\Models\PostReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class ReportPost extends Component
{
    public Post $post;
    public bool $showModal = false;
    public string $reason  = '';
    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'Podaj powód zgłoszenia.',
            'reason.max'      => 'Powód nie może przekraczać 1000 znaków.',
        ]);

        $already = PostReport::where('post_id', $this->post->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($already) {
            $this->showModal = false;
            $this->submitted = true;
            return;
        }

        PostReport::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'reason'  => $this->reason,
            'status'  => 'oczekujące',
        ]);

        $this->reason    = '';
        $this->showModal = false;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.reports.report-post');
    }
}
