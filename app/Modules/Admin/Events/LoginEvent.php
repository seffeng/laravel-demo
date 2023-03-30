<?php

namespace App\Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Modules\Admin\Models\Admin;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *
     * @var Admin
     */
    private $model;

    /**
     * @var array
     */
    private $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $model, array $data = [])
    {
        $this->model = $model;
        $this->data = $data;
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

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return Admin
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     * @author zxf
     * @date   2023-03-27
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
