<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Uniwersalny sygnał "coś się zmieniło na liście X" — komponenty Livewire
 * nasłuchują na danym kanale i dociągają świeże dane po stronie serwera.
 *
 * @example ResourceChanged::dispatch('missions');  // echo:missions,.ResourceChanged
 */
class ResourceChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $channelName)
    {
    }

    public function broadcastOn(): array
    {
        return [new Channel($this->channelName)];
    }

    public function broadcastAs(): string
    {
        return 'ResourceChanged';
    }
}
