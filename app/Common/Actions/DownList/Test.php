<?php

namespace App\Common\Actions\DownList;

class Test
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
        $data = [];
        $items = ['appName' => config('app.name'), 'key1' => 'value1', 'key2' => 'value2'];
        if ($items) foreach ($items as $key => $item) {
            $data[] = [
                'id' => $key,
                'name' => $item
            ];
        }
        return $data;
    }
}