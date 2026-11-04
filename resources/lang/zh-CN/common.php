<?php

return [
    'required' => ':attribute不能为空！',
    'min' => ':attribute至少:min位字符！',
    'max' => ':attribute最多:max位字符！',
    'between' => ':attribute必须:min~:max位字符！',
    'unique' => ':attribute已存在！',
    'integer' => ':attribute只能是数字！',
    'string' => ':attribute只能是字符串！',
    'in' => ':attribute不支持该值！',
    'date' => ':attribute格式错误！',
    'image' => ':attribute必须为图片！',
    'startGtEnd' => '开始时间不能大于结束时间！',

    'validatorError' => '数据未验证通过！',
    'signParamRequired' => '缺少签名参数！',
    'signDomainDeny' => '签名未授权！',
    'signInvalid' => '签名无效！',
];
