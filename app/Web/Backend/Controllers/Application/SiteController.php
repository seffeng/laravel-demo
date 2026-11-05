<?php

namespace App\Web\Backend\Controllers\Application;

use App\Modules\Application\Exceptions\ApplicationException;
use App\Modules\Application\Services\ApplicationService;
use Illuminate\Http\Request;
use App\Web\Backend\Common\Controller;
use App\Web\Backend\Requests\Application\ApplicationSearchRequest;
use App\Web\Backend\Requests\Application\ApplicationCreateRequest;
use App\Web\Backend\Requests\Application\ApplicationStatusRequest;
use App\Web\Backend\Requests\Application\ApplicationUpdateRequest;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
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

            $items = $this->getApplicationService()->getApplicationStore($form);
            return $this->responseSuccess($items);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
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
                if ($model = $this->getApplicationService()->create($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('application.createSuccess'));
                }
            }
            return $this->responseError(trans('application.createFailure'));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
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
                if ($model = $this->getApplicationService()->update($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('application.updateSuccess'));
                }
            }
            return $this->responseError(trans('application.updateFailure'));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $form = $this->getStatusRequest();
            $validator = Validator::make($form->load($request->input()), $form->rules(), $form->messages(), $form->attributes());
            if ($errorItems = $form->getErrorItems($validator)) {
                return $this->responseError($errorItems['message'], $errorItems['data']);
            } else {
                if ($model = $this->getApplicationService()->delete($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('application.deleteSuccess'));
                }
                return $this->responseError(trans('application.deleteFailure'));
            }
        } catch (ApplicationException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
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
                if ($model = $this->getApplicationService()->on($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('application.onSuccess'));
                }
                return $this->responseError(trans('application.onFailure'));
            }
        } catch (ApplicationException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @param  Request $request
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
                if ($model = $this->getApplicationService()->off($form, true)) {
                    $request->merge(['operateLogParams' => $form->getOperateLogParams()]);
                    return $this->responseSuccess(['id' => $model->id], trans('application.offSuccess'));
                }
                return $this->responseError(trans('application.offFailure'));
            }
        } catch (ApplicationException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @return ApplicationService
     */
    private function getApplicationService()
    {
        return new ApplicationService();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @return ApplicationSearchRequest
     */
    private function getSearchRequest()
    {
        return new ApplicationSearchRequest();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @return ApplicationCreateRequest
     */
    private function getCreateRequest()
    {
        return new ApplicationCreateRequest();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @return ApplicationUpdateRequest
     */
    private function getUpdateRequest()
    {
        return new ApplicationUpdateRequest();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-24
     * @return ApplicationStatusRequest
     */
    private function getStatusRequest()
    {
        return new ApplicationStatusRequest();
    }
}
