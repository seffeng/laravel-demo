<?php

namespace App\Web\Backend\Requests\Admin;

use App\Common\Constants\FromConst;
use App\Common\Rules\Password;
use Seffeng\LaravelRSA\Facades\RSA;

class AdminLoginRequest extends \App\Modules\Admin\Requests\AdminLoginRequest
{
    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::rules()
     */
    public function rules()
    {
        $rules = [];
        if (config('rsa.clients.' . FromConst::BACKEND_NAME . '.enable.password')) {
            $rules['password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        $password = RSA::loadClient(FromConst::BACKEND_NAME)->decrypt(base64_decode($value));
                        $passRule = new Password();
                        if ($password && $passRule->passes($attribute, $password)) {
                            $this->setFillItem($attribute, $password);
                        } else {
                            return $fail(trans('admin.passError'));
                        }
                    } catch (\Exception $e) {
                        return $fail(trans('admin.passError'));
                    }
                }
            ];
        }
        return array_merge(parent::rules(), $rules);
    }
}
