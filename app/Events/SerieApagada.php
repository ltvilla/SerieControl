<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use PhpParser\Node\Expr\Cast\Object_;

class SerieApagada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $serie;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Object $serie)
    {
        $this->serie = $serie;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
