<?php

namespace App\Web\Www\Controllers\Auth;

use Illuminate\Http\Request;
use App\Web\Www\Common\Controller;
use App\Common\Constants\ErrorConst;
use App\Modules\User\Services\UserService;
use App\Web\Www\Requests\Auth\UserLoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Modules\User\Exceptions\UserException;

class SiteController extends Controller
{
    /**
     *
     * @author zxf
     * @date   2019年10月20日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->post(), $this->getUserLoginRequest()->rules(), $this->getUserLoginRequest()->messages(), $this->getUserLoginRequest()->attributes());
            if ($errorItems = $this->getUserLoginRequest()->getErrorItems($validate)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($this->getUserService()->userLogin($request->post('username'), $request->post('password'))) {
                    return $this->responseSuccess([
                        'user' => $this->getUserService()->getLoginUserToArray()
                    ], '登录成功！');
                }
                return $this->responseError('登录失败！');
            }
        } catch (UserException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseError(ErrorConst::getError());
        }
    }

    /**
     *
     * @author zxf
     * @date   2019年10月19日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->getUserService()->userLogout();
        return $this->responseSuccess(['url' => '/login']);
    }

    /**
     *
     * @author zxf
     * @date   2019年10月19日
     * @return \Illuminate\Http\JsonResponse
     */
    public function isLogin(Request $request)
    {
        return $this->responseSuccess([
            'isLogin' => $this->getUserService()->userIsLogin(),
            'user' => $this->getUserService()->getLoginUserToArray() ?: new \stdClass()
        ]);
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return UserService
     */
    private function getUserService()
    {
        return new UserService();
    }

    /**
     *
     * @author zxf
     * @date   2019年10月20日
     * @return UserLoginRequest
     */
    private function getUserLoginRequest()
    {
        return new UserLoginRequest();
    }
}
