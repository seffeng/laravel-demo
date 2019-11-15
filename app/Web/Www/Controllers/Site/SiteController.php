<?php

namespace App\Web\Www\Controllers\Site;

use App\Web\Www\Common\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    const TYPE_CSRF_TOKEN = 'csrf_token';
    const TYPE_TEST = 'test';

    /**
     *
     * @author zxf
     * @date   2019年10月19日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDownList(Request $request)
    {
        $type = $request->get('type');
        $data = [];
        $type = str_replace(' ', '', $type);
        if (strpos($type, ',') !== false) {
            $typeList = explode(',', $type);
        } else {
            $typeList = [$type];
        }
        foreach ($typeList as $type) {
            switch ($type) {
                case self::TYPE_CSRF_TOKEN : {
                    $data[$type] = csrf_token();
                    break;
                }
                case self::TYPE_TEST : {
                    $data[$type] = ['key1' => 'value1', 'key2' => 'value2'];
                    break;
                }
            }
        }
        return $this->responseSuccess($data);
    }
}
