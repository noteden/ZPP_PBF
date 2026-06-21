<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Nadawane po zmianie postaci/karty (XP, PH, statystyki, akceptacja umiejętności) — live karta postaci. */
class CharacterUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $characterId;

    public function __construct(int $characterId)
    {
        $this->characterId = $characterId;
    }

    public function broadcastOn(): array
    {
        // Sygnał tylko z id — komponent dociąga dane po stronie serwera z autoryzacją.
        return [new Channel('character.'.$this->characterId)];
    }

    public function broadcastAs(): string
    {
        return 'CharacterUpdated';
    }
}
