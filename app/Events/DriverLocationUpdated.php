<?php

namespace App\Events;

use App\Models\Distributor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public Distributor $loc;

    public function __construct(Distributor $loc)
    {
        $this->loc = $loc;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('drivers.locations');
    }

    public function broadcastAs(): string
    {
        return 'location.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->loc->id,
            'latitude' => (float)$this->loc->latitude,
            'longitude' => (float)$this->loc->longitude,
            'last_update' => optional($this->loc->last_update)->toDateTimeString(),
        ];
    }
}