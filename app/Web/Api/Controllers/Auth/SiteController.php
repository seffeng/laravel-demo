<?php

namespace App\Web\Api\Controllers\Auth;

use App\Web\Api\Common\Controller;
use Illuminate\Http\Request;
use App\Web\Api\Requests\Auth\UserLoginRequest;
use App\Modules\User\Exceptions\UserException;
use Illuminate\Support\Facades\Validator;
use App\Modules\User\Services\UserService;

class SiteController extends Controller
{
    /**
     *
     * @author zxf
     * @date   2020年1月1日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $form = $this->getUserLoginRequest();
            $validate = Validator::make($form->load($request->post()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validate)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                $userService = $this->getUserService();
                if ($userService->userLogin($form->getFillItems('username'), $form->getFillItems('password'))) {
                    $user = $userService->getLoginUser();
                    return $this->responseSuccess([
                        'user' => $userService->getLoginUserToArray(),
                        'token' => $user->createToken($user->username)->accessToken
                    ], trans('user.login_success'));
                }
                return $this->responseError(trans('user.login_failure'));
            }
        } catch (UserException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年1月1日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $userService = $this->getUserService();
        $userService->setAuth('api');
        $userService->userLogout();
        return $this->responseSuccess(['url' => '/login']);
    }

    /**
     *
     * @author zxf
     * @date   2020年1月1日
     * @return \Illuminate\Http\JsonResponse
     */
    public function isLogin(Request $request)
    {
        $userService = $this->getUserService();
        $userService->setAuth('api');
        return $this->responseSuccess([
            'isLogin' => $userService->userIsLogin(),
            'user' => $userService->getLoginUserToArray() ?: new \stdClass()
        ]);
    }

    /**
     *
     * @author zxf
     * @date   2020年1月1日
     * @return \App\Modules\User\Services\UserService
     */
    private function getUserService()
    {
        return new UserService();
    }

    /**
     *
     * @author zxf
     * @date   2020年1月1日
     * @return UserLoginRequest
     */
    private function getUserLoginRequest()
    {
        return new UserLoginRequest();
    }
}