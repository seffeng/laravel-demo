<?php

namespace App\Modules\Admin\Requests;

use App\Common\Base\FormRequest;
use App\Common\Rules\Password;
use Seffeng\LaravelHelpers\Helpers\Arr;

class AdminLoginRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'remember'];

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
     * @see \Seffeng\Basics\Base\FormRequest::rules()
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'min:5',
                'max:16'
            ],
            'password' => [
                'required',
                'between:6,20',
                new Password()
            ],
            'remember' => [
                function($attribute, $value, $fail) {
                    $this->setFillItem($attribute, boolval($value));
                }
            ]
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::messages()
     */
    public function messages()
    {
        return Arr::merge(parent::messages(), [
        ]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::attributes()
     */
    public function attributes()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}
