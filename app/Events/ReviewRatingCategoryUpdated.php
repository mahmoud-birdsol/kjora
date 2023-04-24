<?php

namespace App\Events;

use App\Models\ReviewRatingCategory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewRatingCategoryUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User|mixed|null
     */
    public mixed $player;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReviewRatingCategory $reviewRatingCategory)
    {
        $this->player = $reviewRatingCategory->review->player;
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
