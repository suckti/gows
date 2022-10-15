<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StravaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * event Data
     */
    // {
    //     "aspect_type": "update",
    //     "event_time": 1665734546,
    //     "object_id": 7960441450,
    //     "object_type": "activity",
    //     "owner_id": 18067797,
    //     "subscription_id": 227088,
    //     "updates": [

    //     ]
    //   }
    public $eventData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventData)
    {
        $this->eventData = $eventData;
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
