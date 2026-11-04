<?php

namespace App\Modules\Application\Services;

use App\Common\Base\Service;
use App\Common\Constants\ModuleConst;
use App\Common\Constants\TypeConst;
use App\Modules\Application\Exceptions\ApplicationException;
use App\Modules\Application\Exceptions\ApplicationNotFoundException;
use App\Modules\Application\Models\Application;
use App\Modules\Application\Requests\ApplicationCreateRequest;
use App\Modules\Application\Requests\ApplicationSearchRequest;
use App\Modules\Application\Requests\ApplicationStatusRequest;
use App\Modules\Application\Requests\ApplicationUpdateRequest;
use Illuminate\Support\Facades\Date;

class ApplicationService extends Service
{
    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  int $id
     * @return Application
     */
    public function getById(int $id)
    {
        return Application::byId($id)->first();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  int $id
     * @return Application
     */
    public function notNullById(int $id)
    {
        try {
            $model = $this->getById($id);
            if ($model) {
                return $model;
            }
            throw new ApplicationNotFoundException(trans('application.notFound'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  string $appKey
     * @return Application
     */
    public function getByAppKey(string $appKey)
    {
        return Application::byAppKey($appKey)->first();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  string $appKey
     * @return Application
     */
    public function notNullByAppKey(string $appKey)
    {
        try {
            $model = $this->getByAppKey($appKey);
            if ($model) {
                return $model;
            }
            throw new ApplicationNotFoundException(trans('application.notFound'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationSearchRequest $form
     * @return array
     */
    public function getApplicationStore(ApplicationSearchRequest $form)
    {
        $paginator = $this->getApplicationPaginate($form);
        $items = [];
        /**
         *
         * @var Application $model
         */
        if ($paginator->count() > 0) {
            foreach ($paginator as $model) {
                $items[] = $this->parseModel($model);
            }
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationSearchRequest $form
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getApplicationPaginate(ApplicationSearchRequest $form)
    {
        /**
         *
         * @var Application $query
         */
        $query = Application::with($form->getWith());
        if ($id = $form->getFillItems('id')) {
            $query->byId($id);
        }
        if ($appKey = $form->getFillItems('appKey')) {
            $query->byAppkey($appKey);
        }
        if ($name = $form->getFillItems('name')) {
            $query->byName($name);
        }
        if ($statusId = $form->getFillItems('statusId')) {
            $query->byStatusId($statusId);
        }
        if ($createdStartAt = $form->getFillItems('startAt')) {
            $query->where('created_at', '>=', Date::parse($createdStartAt)->format((new Application())->getDateFormat()));
        }
        if ($createdEndAt = $form->getFillItems('endAt')) {
            $query->where('created_at', '<', Date::parse($createdEndAt)->addDay()->format((new Application())->getDateFormat()));
        }

        if ($orderItems = $form->getOrderBy()) {
            foreach ($orderItems as $attribute => $order) {
                $query->orderBy($attribute, $order);
            }
        } else {
            $query->orderBy('id', TypeConst::ORDERBY_DESC);
        }
        return $query->paginate($form->getPerPage());
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationCreateRequest $form
     * @param  bool $assoc
     * @return Application|bool
     */
    public function create(ApplicationCreateRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = new Application();
                $model->fill(array_filter($form->getFillItems(), function($value) {
                    return $value;
                }));
                $model->loadDefaultValue()->generateAppkey()->generateAppsecret();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_CREATE, ModuleConst::APPLICATION);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new ApplicationException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationUpdateRequest $form
     * @param  bool $assoc
     * @return Application|bool
     */
    public function update(ApplicationUpdateRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                $model->fill(array_filter($form->getFillItems(), function($value) {
                    return !is_null($value);
                }));
                $diffChange = $model->diffChanges();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_UPDATE, ModuleConst::APPLICATION, $diffChange);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new ApplicationException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationStatusRequest $form
     * @return bool
     */
    public function delete(ApplicationStatusRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                if ($model->delete()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_DELETE, ModuleConst::APPLICATION);
                    return true;
                }
                return false;
            }
            throw new ApplicationException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationStatusRequest $form
     * @return bool
     */
    public function on(ApplicationStatusRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                $model->onApplication();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_ON, ModuleConst::APPLICATION);
                    return true;
                }
                return false;
            }
            throw new ApplicationException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  ApplicationStatusRequest $form
     * @return bool
     */
    public function off(ApplicationStatusRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                $model->offApplication();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_OFF, ModuleConst::APPLICATION);
                    return true;
                }
                return false;
            }
            throw new ApplicationException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @param  Application $model
     * @return array
     */
    protected function parseModel(Application $model)
    {
        return $this->filterByFillable([
            'id' => $model->id,
            'name' => $model->name,
            'appKey' => $model->app_key,
            'appSecret' => $model->app_secret,
            'allowIps' => $model->allow_ips,
            'denyIps' => $model->deny_ips,
            'domain' => $model->domain,
            'description' => $model->description,
            'status' => [
                'id' => $model->status_id,
                'name' => $model->getStatus()->getName(),
                'isNormal' => $model->getStatus()->getIsOn()
            ],
            'createdAt' => $model->created_at,
            'updatedAt' => $model->updated_at,
        ]);
    }
}
