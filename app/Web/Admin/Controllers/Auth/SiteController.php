<?php

namespace App\Web\Admin\Controllers\Auth;

use Illuminate\Http\Request;
use App\Web\Admin\Common\Controller;
use App\Common\Constants\ErrorConst;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Services\AdminService;
use App\Web\Admin\Requests\Admin\AdminLoginRequest;
use App\Modules\Admin\Exceptions\AdminException;

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
            $form = $this->getAdminLoginRequest();
            $validate = Validator::make($form->load($request->post()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validate)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($this->getAdminService()->adminLogin($form->getFillItems('phone'), $form->getFillItems('password'))) {
                    return $this->responseSuccess([
                        'admin' => $this->getAdminService()->getLoginAdminToArray()
                    ], '登录成功！');
                }
                return $this->responseError('登录失败！');
            }
        } catch (AdminException $e) {
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
        $this->getAdminService()->adminLogout();
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
            'isLogin' => $this->getAdminService()->adminIsLogin(),
            'admin' => $this->getAdminService()->getLoginAdminToArray() ?: new \stdClass()
        ]);
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return AdminService
     */
    private function getAdminService()
    {
        return new AdminService();
    }

    /**
     *
     * @author zxf
     * @date   2019年10月20日
     * @return AdminLoginRequest
     */
    private function getAdminLoginRequest()
    {
        return new AdminLoginRequest();
    }
}
