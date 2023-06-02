<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Signal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomId;
    public $signalData;

    public function __construct($roomId, $signalData)
    {
        $this->roomId = $roomId;
        $this->signalData = $signalData;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('webrtc.' . $this->roomId);
    }
}
