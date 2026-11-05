<?php

namespace App\Web\Frontend\Requests\Auth;

use App\Common\Constants\FromConst;
use App\Common\Rules\Password;
use Seffeng\LaravelRSA\Facades\RSA;

class UserLoginRequest extends \App\Modules\User\Requests\UserLoginRequest
{
    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::rules()
     */
    public function rules()
    {
        $rules = [];
        if (config('rsa.clients.' . FromConst::FRONTEND_NAME . '.enable.password')) {
            $rules['password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        $password = RSA::loadClient(FromConst::FRONTEND_NAME)->decrypt(base64_decode($value));
                        $passRule = new Password();
                        if ($password && $passRule->passes($attribute, $password)) {
                            $this->setFillItem($attribute, $password);
                        } else {
                            return $fail(trans('user.passError'));
                        }
                    } catch (\Exception $e) {
                        return $fail(trans('user.passError'));
                    }
                }
            ];
        }
        return array_merge(parent::rules(), $rules);
    }
}
