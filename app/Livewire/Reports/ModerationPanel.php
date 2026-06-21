<?php

namespace App\Livewire\Reports;

use App\Enums\ReportStatus;
use App\Models\PostReport;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Panel moderacji')]
class ModerationPanel extends Component
{
    use WithPagination;

    public string $filter = ReportStatus::Pending->value;

    public function getListeners(): array
    {
        return ['echo:moderators,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->reports);
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function markReviewed(int $id): void
    {
        PostReport::findOrFail($id)->update(['status' => ReportStatus::Reviewed]);
        unset($this->reports);
    }

    #[Computed]
    public function reports(): LengthAwarePaginator
    {
        return PostReport::with(['user', 'post.user'])
            ->where('status', $this->filter)
            ->latest()
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.reports.moderation-panel')
            ->layout('layouts.app');
    }
}
