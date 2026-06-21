<?php

namespace App\Livewire\ActivityLog;

use App\Models\ActivityLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Log aktywności')]
class ActivityLogList extends Component
{
    use WithPagination;

    public string $filterAction  = '';
    public string $filterSubject = '';

    public function getListeners(): array
    {
        return ['echo:activity,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->logs);
    }

    public function updatingFilterAction(): void
    {
        $this->resetPage();
    }

    public function updatingFilterSubject(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function logs(): LengthAwarePaginator
    {
        $query = ActivityLog::with('user')->latest();

        if ($this->filterAction) {
            $query->where('action', $this->filterAction);
        }

        if ($this->filterSubject) {
            $query->where('subject_type', $this->filterSubject);
        }

        return $query->paginate(25);
    }

    public function render()
    {
        return view('livewire.activity-log.activity-log-list')
            ->layout('layouts.app');
    }
}
