<?php

namespace App\Web\Admin\Controllers\Admin;

use Illuminate\Http\Request;
use App\Web\Admin\Common\Controller;
use App\Common\Constants\ErrorConst;
use App\Modules\Admin\Services\AdminService;
use App\Web\Admin\Requests\Admin\AdminSearchRequest;
use Illuminate\Support\Facades\Validator;
use App\Web\Admin\Requests\Admin\AdminCreateRequest;
use App\Web\Admin\Requests\Admin\AdminUpdateRequest;
use App\Modules\Admin\Exceptions\AdminException;

class SiteController extends Controller
{
    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $form = $this->getAdminSearchRequest();
            $form->load($request->all());
            $items = $this->getAdminService()->getAdminStore($form);
            return $this->responseSuccess($items);
        } catch (\Exception $e) {
            return $this->responseError(ErrorConst::getError(), config('app.debug') ? ['message' => $e->getMessage()] : []);
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $form = $this->getAdminCreateRequest();
            $validator = Validator::make($form->load($request->all()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($this->getAdminService()->createAdmin($form)) {
                    return $this->responseSuccess([], '管理员添加成功！');
                }
            }
            return $this->responseError('管理员添加失败！');
        } catch (\Exception $e) {
            return $this->responseError(ErrorConst::getError(), config('app.debug') ? ['message' => $e->getMessage()] : []);
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $form = $this->getAdminUpdateRequest();
            $validator = Validator::make($form->load($request->all()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($this->getAdminService()->updateAdmin($form)) {
                    return $this->responseSuccess([], '管理员修改成功！');
                }
            }
            return $this->responseError('管理员修改失败！');
        } catch (\Exception $e) {
            return $this->responseError(ErrorConst::getError(), config('app.debug') ? ['message' => $e->getMessage()] : []);
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->get('id');
            if ($this->getAdminService()->deleteAdmin($id)) {
                return $this->responseSuccess([], '管理员删除成功！');
            }
            return $this->responseError('管理员删除失败！');
        } catch (AdminException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseError(ErrorConst::getError(), config('app.debug') ? ['message' => $e->getMessage()] : []);
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return \App\Modules\Admin\Services\AdminService
     */
    private function getAdminService()
    {
        return new AdminService();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return AdminSearchRequest
     */
    private function getAdminSearchRequest()
    {
        return new AdminSearchRequest();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return AdminCreateRequest
     */
    private function getAdminCreateRequest()
    {
        return new AdminCreateRequest();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return AdminUpdateRequest
     */
    private function getAdminUpdateRequest()
    {
        return new AdminUpdateRequest();
    }
}
