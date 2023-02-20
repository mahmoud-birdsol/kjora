<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User
     */
    private User $user;

    /**
     * @var \App\Models\Message
     */
    private Message $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\PrivateChannel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('users.chat.'.$this->user->id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'message-sent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $data = $this->message;

        return $data->toArray();
    }
}
