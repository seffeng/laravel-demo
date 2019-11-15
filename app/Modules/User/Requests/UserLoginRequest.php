<?php

namespace App\Modules\User\Requests;

use App\Common\Base\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::authorize()
     */
    public function authorize()
    {
        return true;
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::rules()
     */
    public function rules()
    {
        return [
            'username' => 'required|min:5|max:16',
            'password' => 'required|between:6,20',
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'required' => ':attribute不能为空！',
            'min' => ':attribute至少:min位字符！',
            'max' => ':attribute最多:max位字符！',
            'between' => ':attribute必须:min~:max位字符！',
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::attributes()
     */
    public function attributes()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}
