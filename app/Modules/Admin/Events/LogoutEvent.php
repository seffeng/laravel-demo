<?php

namespace App\Modules\Admin\Events;

use App\Modules\Admin\Models\Admin;

class LogoutEvent
{
    /**
     *
     * @var Admin
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
     * @param  Admin $model
     * @return void
     */
    public function __construct(Admin $model, array $data = [])
    {
        $this->model = $model;
        $this->data = $data;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return Admin
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
