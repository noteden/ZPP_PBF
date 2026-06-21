<?php

namespace App\Livewire\Missions;

use App\Models\Mission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Misje')]
class Index extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:5000')]
    public string $description = '';

    public function getListeners(): array
    {
        return ['echo:missions,.ResourceChanged' => 'refreshList'];
    }

    public function refreshList(): void
    {
        unset($this->missions, $this->myReviews, $this->myMissionIds);
    }

    #[Computed]
    public function missions(): Collection
    {
        return Mission::with('proposer')->orderByDesc('id')->get();
    }

    #[Computed]
    public function myMissionIds(): array
    {
        return Mission::query()
            ->whereHas('users', fn ($q) => $q->where('users.id', Auth::id()))
            ->pluck('missions.id')
            ->toArray();
    }

    #[Computed]
    public function myReviews(): Collection
    {
        return collect(\DB::table('mission_user_review')
            ->where('user_id', Auth::id())
            ->get())
            ->keyBy('mission_id');
    }

    public function propose(): void
    {
        $this->validate();

        Mission::create([
            'name'        => $this->name,
            'description' => $this->description,
            'proposed_by' => Auth::id(),
            'status'      => 'proposed',
        ]);

        $this->reset(['name', 'description']);
        unset($this->missions);
    }

    public function join(int $missionId): void
    {
        $mission = Mission::findOrFail($missionId);

        if (!$mission->users()->where('users.id', Auth::id())->exists()) {
            $mission->users()->attach(Auth::id(), ['review' => false]);
        }

        unset($this->myMissionIds, $this->myReviews);
    }

    public function leave(int $missionId): void
    {
        Mission::findOrFail($missionId)->users()->detach(Auth::id());

        unset($this->myMissionIds, $this->myReviews);
    }

    public function toggleReview(int $missionId): void
    {
        $mission = Mission::findOrFail($missionId);

        $current = \DB::table('mission_user_review')
            ->where('mission_id', $missionId)
            ->where('user_id', Auth::id())
            ->value('review');

        if ($current === null) {
            $mission->users()->attach(Auth::id(), ['review' => true]);
        } else {
            \DB::table('mission_user_review')
                ->where('mission_id', $missionId)
                ->where('user_id', Auth::id())
                ->update(['review' => ! (bool) $current]);
        }

        unset($this->myMissionIds, $this->myReviews);
    }

    /** Ocena misji przez rolę werdyktującą (MG/Admin). */
    public function rate(int $missionId, int $rating): void
    {
        abort_unless(Auth::user()?->isModerator(), 403);

        $rating = max(1, min(5, $rating));
        $mission = Mission::findOrFail($missionId);

        $exists = \DB::table('mission_user_review')
            ->where('mission_id', $missionId)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            \DB::table('mission_user_review')
                ->where('mission_id', $missionId)
                ->where('user_id', Auth::id())
                ->update(['rating' => $rating]);
        } else {
            $mission->users()->attach(Auth::id(), ['review' => false, 'rating' => $rating]);
        }

        unset($this->missions, $this->myReviews);
    }

    public function render()
    {
        return view('livewire.missions.index')->layout('layouts.app');
    }
}
