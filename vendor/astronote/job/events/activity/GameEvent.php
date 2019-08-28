<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $target;
    public $payload;

    public function __construct($target = null, ...$payload)
    {
        $this->target = $target;
        $this->payload = count($payload) <= 0 ? null : $payload;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-game-event');
    }
}
