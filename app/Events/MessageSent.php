<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender_id;
    public $receiver_id;
    public $message;

    public function __construct($sender_id, $receiver_id, $message)
    {
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $channelId = $this->generateChannelId($this->sender_id, $this->receiver_id);
        return ['chat.' . $channelId];
    }

    private function generateChannelId($sender_id, $receiver_id)
    {
        return implode('.', [min($sender_id, $receiver_id), max($sender_id, $receiver_id)]);
    }
}
