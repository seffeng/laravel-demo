<?php

namespace App\Common\Constants;

use Illuminate\Support\Facades\Request;
use Seffeng\LaravelHelpers\Helpers\Arr;
use Seffeng\ArrHelper\ReplaceArrayValue;

/**
 * 错误常量
 * @author zxf
 */
class ErrorConst extends \Seffeng\Basics\Constants\ErrorConst
{
    /**
     *
     * @var integer
     */
    const SERVER_ERROR = 500;

    /**
     *
     * @author zxf
     * @date    2019年12月5日
     * @return array
     */
    public static function fetchNameItems()
    {
        return Arr::merge(parent::fetchNameItems(), [
            static::NOT_FOUND => new ReplaceArrayValue('接口不存在！'),
            static::SERVER_ERROR => '服务器错误！',
        ]);
    }

    /**
     *
     * @author zxf
     * @date   2023-08-28
     * @param array $headers
     * @param array $customHeaders
     * @return array
     */
    public static function mergeHeaders(array $headers = [], array $customHeaders = [])
    {
        $customHeaders = [];
        if ($token = Request::header('Refresh-Token')) {
            $customHeaders['Refresh-Token'] = $token;
            $customHeaders['Access-Control-Expose-Headers'][] = 'Refresh-Token';
        }
        return parent::mergeHeaders($headers, $customHeaders);
    }
}
