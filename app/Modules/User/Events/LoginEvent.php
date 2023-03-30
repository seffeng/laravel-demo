<?php

namespace App\Modules\User\Events;

use App\Modules\User\Models\User;

class LoginEvent
{
    /**
     *
     * @var User
     */
    private $model;

    /**
     *
     * @var array
     */
    private $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $model, array $data = [])
    {
        $this->model = $model;
        $this->data = $data;
    }

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     * @author zxf
     * @date   2020年12月28日
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
