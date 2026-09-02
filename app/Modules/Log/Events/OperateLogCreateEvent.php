<?php

namespace App\Modules\Log\Events;

/**
 *
 * @author zxf
 * @date   2026-08-27
 */
class OperateLogCreateEvent
{
    /**
     *
     * @var mixed
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
     * @param  mixed $model
     * @return void
     */
    public function __construct($model, array $data = [])
    {
        //
        $this->model = $model;
        $this->data = $data;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return mixed
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
