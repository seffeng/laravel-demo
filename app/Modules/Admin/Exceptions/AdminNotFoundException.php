<?php

namespace App\Modules\Admin\Exceptions;

class AdminNotFoundException extends AdminException
{
    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return string
     */
    protected function defaultMessage()
    {
        return trans('admin.notFound');
    }
}
