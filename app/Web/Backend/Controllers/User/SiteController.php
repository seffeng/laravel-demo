<?php

namespace App\Web\Backend\Controllers\User;

use App\Modules\User\Exceptions\UserException;
use Illuminate\Http\Request;
use App\Web\Backend\Common\Controller;
use App\Modules\User\Services\UserService;
use App\Web\Backend\Requests\User\UserCreateRequest;
use App\Web\Backend\Requests\User\UserDeleteRequest;
use App\Web\Backend\Requests\User\UserSearchRequest;
use App\Web\Backend\Requests\User\UserStatusRequest;
use App\Web\Backend\Requests\User\UserUpdateRequest;
use Illuminate\Support\Facades\Validator;

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
            $form = $this->getSearchRequest();
            $form->load($request->input());
            $perPage = $request->get($form->getPerPageName());
            $perPage > 0 && $form->setPerPage($perPage);
            $form->sortable();
            $items = $this->getService()->getUserStore($form);
            return $this->responseSuccess($items);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $form = $this->getCreateRequest();
            $validator = Validator::make($form->load($request->post()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getService()->createUser($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('user.createSuccess'));
                }
            }
            return $this->responseError(trans('user.createFailure'));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $form = $this->getUpdateRequest();
            $validator = Validator::make($form->load($request->input()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getService()->updateUser($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('user.updateSuccess'));
                }
            }
            return $this->responseError(trans('user.updateFailure'));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $form = $this->getDeleteRequest();
            $validator = Validator::make($form->load($request->input()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getService()->deleteUser($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('user.deleteSuccess'));
                }
                return $this->responseError(trans('user.deleteFailure'));
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
     * @date   2024-05-23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function on(Request $request)
    {
        try {
            $form = $this->getStatusRequest();
            $validator = Validator::make($form->load($request->input()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getService()->onUser($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('user.onSuccess'));
                }
                return $this->responseError(trans('user.onFailure'));
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
     * @date   2024-05-23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function off(Request $request)
    {
        try {
            $form = $this->getStatusRequest();
            $validator = Validator::make($form->load($request->input()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getService()->offUser($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('user.offSuccess'));
                }
                return $this->responseError(trans('user.offFailure'));
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
     * @date    2019年10月29日
     * @return UserService
     */
    private function getService()
    {
        return new UserService();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return UserSearchRequest
     */
    private function getSearchRequest()
    {
        return new UserSearchRequest();
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @return UserCreateRequest
     */
    private function getCreateRequest()
    {
        return new UserCreateRequest();
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @return UserUpdateRequest
     */
    private function getUpdateRequest()
    {
        return new UserUpdateRequest();
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @return UserDeleteRequest
     */
    private function getDeleteRequest()
    {
        return new UserDeleteRequest();
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @return UserStatusRequest
     */
    private function getStatusRequest()
    {
        return new UserStatusRequest();
    }
}
