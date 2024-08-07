<?php
namespace App\Modules\Log\Services;

use App\Common\Base\Service;
use App\Modules\Log\Models\AdminLoginLog;
use App\Modules\Log\Requests\AdminLoginLogCreateRequest;
use App\Modules\Log\Requests\OperateLogCreateRequest;
use App\Modules\Log\Models\OperateLog;
use Seffeng\LaravelHelpers\Helpers\Json;
use App\Modules\Log\Models\UserLoginLog;
use App\Modules\Log\Requests\UserLoginLogCreateRequest;
use App\Modules\Log\Exceptions\LoginLogException;
use App\Modules\Log\Requests\OperateLogSearchRequest;
use App\Modules\Log\Requests\AdminLoginLogSearchRequest;
use App\Modules\Log\Requests\UserLoginLogSearchRequest;
use Seffeng\LaravelHelpers\Helpers\Arr;
use App\Common\Constants\FormatConst;
use App\Common\Constants\TypeConst;
use Illuminate\Support\Facades\Date;

class LogService extends Service
{
    /**
     *
     * @author zxf
     * @date   2020年12月10日
     * @param AdminLoginLogCreateRequest $form
     * @throws \Exception
     * @return boolean
     */
    public function createAdminLoginLog(AdminLoginLogCreateRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = new AdminLoginLog();
                $model->fill($form->getFillItems());
                $model->loadDefaultValue();
                return $model->save();
            }
            throw new LoginLogException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年12月25日
     * @param UserLoginLogCreateRequest $form
     * @throws \Exception
     * @return boolean
     */
    public function createUserLoginLog(UserLoginLogCreateRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = new UserLoginLog();
                $model->fill($form->getFillItems());
                $model->loadDefaultValue();
                return $model->save();
            }
            throw new LoginLogException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年12月10日
     * @param OperateLogCreateRequest $form
     * @throws \Exception
     * @return boolean
     */
    public function createOperateLog(OperateLogCreateRequest $form)
    {
        try {
            if ($form->getIsPass()) {
                $model = new OperateLog();
                $form->setFillItem('detail', Json::encode($form->getFillItems('detail', [])));
                $model->fill($form->getFillItems());
                $model->loadDefaultValue();
                return $model->save();
            }
            throw new LoginLogException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2021年1月6日
     * @param AdminLoginLogSearchRequest $form
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAdminLoginLogPaginate(AdminLoginLogSearchRequest $form)
    {
        /**
         *
         * @var AdminLoginLog $query
         */
        $query = AdminLoginLog::on()->with($form->getWith());
        if ($id = $form->getFillItems('id')) {
            $query->byId($id);
        }
        if ($adminId = $form->getFillItems('adminId')) {
            $query->byAdminId($adminId);
        }
        if ($username = $form->getFillItems('username')) {
            $query->whereHas('admin', function($query) use ($username) {
                $query->likeUsername($username);
            });
        }
        if ($statusId = $form->getFillItems('statusId')) {
            $query->byStatusId($statusId);
        }
        if ($typeId = $form->getFillItems('typeId')) {
            $query->byTypeId($typeId);
        }
        if ($fromId = $form->getFillItems('fromId')) {
            $query->byFromId($fromId);
        }
        if ($createdStartAt = $form->getFillItems('startDate')) {
            $query->where('created_at', '>=', Date::parse($createdStartAt)->format((new AdminLoginLog())->getDateFormat()));
        }
        if ($createdEndAt = $form->getFillItems('endDate')) {
            $query->where('created_at', '<=', Date::parse($createdEndAt)->addDay()->format((new AdminLoginLog())->getDateFormat()));
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
     * @date   2021年1月6日
     * @param  AdminLoginLogSearchRequest $form
     * @return array
     */
    public function getAdminLoginLogStore(AdminLoginLogSearchRequest $form)
    {
        $paginator = $this->getAdminLoginLogPaginate($form);
        $items = [];
        /**
         *
         * @var AdminLoginLog $model
         */
        if ($paginator) foreach ($paginator as $model) {
            $items[] = $this->parseLoginLogModel($model);
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date   2021年8月5日
     * @param UserLoginLogSearchRequest $form
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserLoginLogPaginate(UserLoginLogSearchRequest $form)
    {
        /**
         *
         * @var UserLoginLog $query
         */
        $query = UserLoginLog::on()->with($form->getWith());
        if ($id = $form->getFillItems('id')) {
            $query->byId($id);
        }
        if ($userId = $form->getFillItems('userId')) {
            $query->byUserId($userId);
        }
        if ($username = $form->getFillItems('username')) {
            $query->whereHas('user', function($query) use ($username) {
                $query->likeUsername($username);
            });
        }
        if ($statusId = $form->getFillItems('statusId')) {
            $query->byStatusId($statusId);
        }
        if ($typeId = $form->getFillItems('typeId')) {
            $query->byTypeId($typeId);
        }
        if ($fromId = $form->getFillItems('fromId')) {
            $query->byFromId($fromId);
        }
        if ($createdStartAt = $form->getFillItems('startAt')) {
            $query->where('created_at', '>=', Date::parse($createdStartAt)->format((new UserLoginLog())->getDateFormat()));
        }
        if ($createdEndAt = $form->getFillItems('endAt')) {
            $query->where('created_at', '<', Date::parse($createdEndAt)->addDay()->format((new UserLoginLog())->getDateFormat()));
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
     * @date   2021年8月5日
     * @param UserLoginLogSearchRequest $form
     * @return array
     */
    public function getUserLoginLogStore(UserLoginLogSearchRequest $form)
    {
        $paginator = $this->getUserLoginLogPaginate($form);
        $items = [];
        /**
         *
         * @var UserLoginLog $model
         */
        if ($paginator) foreach ($paginator as $model) {
            $items[] = $this->parseLoginLogModel($model);
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date   2021年8月5日
     * @param UserLoginLog|AdminLoginLog $model
     * @return array
     */
    protected function parseLoginLogModel($model)
    {
        if ($model instanceof UserLoginLog) {
            $user = $model->user;
        } elseif ($model instanceof AdminLoginLog) {
            $user = $model->admin;
        } else {
            $user = null;
        }
        return $this->filterByFillable([
            'id' => $model->id,
            'username' => Arr::get($user, 'username', ''),
            'status' => [
                'id' => $model->status_id,
                'name' => $model->getStatus()->getName(),
                'isSuccess' => $model->getStatus()->isSuccess()
            ],
            'type' => [
                'id' => $model->type_id,
                'name' => $model->getType()->getName()
            ],
            'from' => [
                'id' => $model->getFrom()->getValue(),
                'name' => $model->getFrom()->getName()
            ],
            'content' => $model->content,
            'createdAt' => $model->created_at
        ]);
    }

    /**
     *
     * @author zxf
     * @date   2021年1月6日
     * @param OperateLogSearchRequest $form
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOperateLogPaginate(OperateLogSearchRequest $form)
    {
        /**
         *
         * @var OperateLog $query
         */
        $query = OperateLog::with($form->getWith());
        if ($id = $form->getFillItems('id')) {
            $query->byId($id);
        }
        if ($resId = $form->getFillItems('resId')) {
            $query->byResId($resId);
        }
        if ($moduleId = $form->getFillItems('moduleId')) {
            $query->byModuleId($moduleId);
        }
        if ($operatorId = $form->getFillItems('operatorId')) {
            $query->byOperatorId($operatorId);
        }
        if ($username = $form->getFillItems('username')) {
            $query->whereHas('operator', function($query) use ($username) {
                $query->byUsername($username);
            });
        }
        if ($statusId = $form->getFillItems('statusId')) {
            $query->byStatusId($statusId);
        }
        if ($typeId = $form->getFillItems('typeId')) {
            $query->byTypeId($typeId);
        }
        if ($fromId = $form->getFillItems('fromId')) {
            $query->byFromId($fromId);
        }
        if ($createdStartAt = $form->getFillItems('startDate')) {
            $query->where('created_at', '>=', Date::parse($createdStartAt)->format((new OperateLog())->getDateFormat()));
        }
        if ($createdEndAt = $form->getFillItems('endDate')) {
            $query->where('created_at', '<=', Date::parse($createdEndAt)->addDay()->format((new OperateLog())->getDateFormat()));
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
     * @date   2021年1月6日
     * @param OperateLogSearchRequest $form
     * @return array
     */
    public function getOperateLogStore(OperateLogSearchRequest $form)
    {
        $paginator = $this->getOperateLogPaginate($form);
        $items = [];
        /**
         *
         * @var OperateLog $model
         */
        if ($paginator) foreach ($paginator as $model) {
            $items[] = $this->parseOperateLogModel($model);
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date   2021年8月5日
     * @param OperateLog $model
     * @return array
     */
    protected function parseOperateLogModel(OperateLog $model)
    {
        $operator = $model->operator;
        $resource = $model->resource;
        $detail = Json::decode($model->detail);
        return $this->filterByFillable([
            'id' => $model->id,
            'operator' => [
                'id' => Arr::get($operator, 'id', ''),
                'username' => Arr::get($operator, 'username', '')
            ],
            'status' => [
                'id' => $model->status_id,
                'name' => $model->getStatus()->getName(),
                'isSuccess' => $model->getStatus()->isSuccess()
            ],
            'type' => [
                'id' => $model->type_id,
                'name' => $model->getType()->getName()
            ],
            'from' => [
                'id' => $model->getFrom()->getValue(),
                'name' => $model->getFrom()->getName()
            ],
            'module' => [
                'id' => $model->module_id,
                'name' => $model->getLogModule()->getName()
            ],
            'resource' => [
                'id' => $model->res_id,
                'name' => Arr::get($resource, 'name', Arr::get($resource, 'username', ''))
            ],
            'content' => $model->content,
            'detail' => $detail ?: new \stdClass(),
            'createdAt' => $model->created_at
        ]);
    }
}
