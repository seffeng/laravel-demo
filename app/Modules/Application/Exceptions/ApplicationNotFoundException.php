<?php

namespace App\Modules\Application\Exceptions;

class ApplicationNotFoundException extends ApplicationException
{
    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return string
     */
    protected function defaultMessage()
    {
        return trans('application.notFound');
    }
}
