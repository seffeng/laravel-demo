<?php

namespace App\Modules\User\Exceptions;

class UserNotFoundException extends UserException
{
    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return string
     */
    protected function defaultMessage()
    {
        return trans('user.notFound');
    }
}
