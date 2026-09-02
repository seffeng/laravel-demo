<?php

namespace App\Common\Actions\DownList;

class CsrfToken
{
    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return void
     */
    public function handle()
    {
        $data = csrf_token();
        return is_null($data) ? '' : $data;
    }
}
