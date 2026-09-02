<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Exceptions\BaseException;
use Illuminate\Support\Facades\Log;
use App\Modules\Log\Events\OperateLogCreateEvent;
use Seffeng\LaravelHelpers\Helpers\Arr;
use Illuminate\Http\Request;
use App\Common\Constants\FromConst;
use App\Modules\Admin\Services\AdminService;
use App\Modules\User\Services\UserService;

class OperateLog
{
    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Request $request
     * @param  Closure $next
     * @param  int $fromId
     * @return bool
     */
    public function handle($request, Closure $next, int $fromId)
    {
        $response = $next($request);
        try {
            $operateLogParams = $request->operateLogParams;
            if ($operateLogParams) foreach ($operateLogParams as $operateLogParam) {
                $model = Arr::get($operateLogParam, 'model');
                $content = Arr::get($operateLogParam, 'content');
                $model && event(new OperateLogCreateEvent($model, [
                    'fromId' => $fromId,
                    'typeId' => Arr::get($operateLogParam, 'typeId', 0),
                    'moduleId' => Arr::get($operateLogParam, 'moduleId', 0),
                    'clientIp' => $request->getClientIp(),
                    'operatorId' => $this->getLoginUserId($fromId),
                    'content' => $content,
                    'diffChanges' => Arr::get($operateLogParam, 'diffChanges', []),
                ]));
            }
        } catch (BaseException $e) {
            Log::error($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $response;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  int $fromId
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|array
     */
    private function getLoginUser(int $fromId)
    {
        try {
            if ($this->isBackend($fromId)) {
                $loginUser = $this->getAdminService()->getLoginAdmin();
            } else {
                $loginUser = $this->getUserService()->getLoginUser();
            }
            return $loginUser;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  int $fromId
     * @return int
     */
    private function getLoginUserId(int $fromId)
    {
        try {
            return Arr::get($this->getLoginUser($fromId), 'id', 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  int $fromId
     * @return bool
     */
    private function isBackend(int $fromId)
    {
        return $fromId === FromConst::BACKEND;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return AdminService
     */
    private function getAdminService()
    {
        return new AdminService();
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return UserService
     */
    private function getUserService()
    {
        return new UserService();
    }
}
