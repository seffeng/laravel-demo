<?php

namespace App\Common\Actions\DownList;

class CsrfToken
{
    /**
     *
     * @author zxf
     * @date   2023-03-27
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function handle($request)
    {
        $data = csrf_token();
        return is_null($data) ? '' : $data;
    }
}