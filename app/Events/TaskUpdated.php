<?php

namespace App\Events;

use App\Http\Resources\TasksResource;
use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskUpdated implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public $queue = 'high';

    /**
     * Create a new event instance.
     */
    public function __construct(public Task $task) {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array {
        try {
            return [
                new PrivateChannel('dashboard.tasks'),
            ];
        } catch (\Throwable $th) {
            dump($th->getMessage());
        }
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array {
        return ['task' => new TasksResource($this->task)];
    }
}