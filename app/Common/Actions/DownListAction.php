<?php

namespace App\Common\Actions;

use Illuminate\Http\Request;
use Seffeng\LaravelHelpers\Helpers\Str;

class DownListAction
{
    const TYPE_CSRF_TOKEN = 'csrfToken';
    const TYPE_TEST = 'test';

    /**
     *
     * @author zxf
     * @date    2019年12月25日
     * @param  string $type
     * @return array
     */
    public function run(Request $request)
    {
        try {
            $data = [];
            $type = $request->get('type');
            $type = str_replace(' ', '', $type);
            if (strpos($type, ',') !== false) {
                $typeList = explode(',', $type);
            } else {
                $typeList = [$type];
            }
            if ($typeList) foreach ($typeList as $type) {
                if (!$this->can($type)) {
                    continue;
                }
                $class =  '\\App\\Common\\Actions\\DownList\\' . Str::studly($type);
                if (class_exists($class)) {
                    $data[$type] = (new $class)->handle($request);
                }
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2023-03-27
     * @param  string $type
     * @return boolean
     */
    protected function can($type)
    {
        return true;
    }
}
