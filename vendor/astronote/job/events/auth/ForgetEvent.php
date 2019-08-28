<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ForgetEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subject;
    public $target;

    public function __construct($target = null, $subject = "Game-Pesanbungkus Forget Account")
    {
        $this->subject = $subject;
        $this->target = $target;

        // dd($target->email);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-forget-event');
    }
}
