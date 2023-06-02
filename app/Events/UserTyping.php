<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $groupId;
    public $isTyping;

    public function __construct($user, $groupId, $isTyping)
    {
        $this->user = $user;
        $this->groupId = $groupId;
        $this->isTyping = $isTyping;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat.{$this->groupId}");
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'isTyping' => $this->isTyping,
        ];
    }
}
