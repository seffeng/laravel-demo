<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Exceptions\BaseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Modules\Admin\Events\LoginEvent as AdminLoginEvent;
use App\Modules\Admin\Events\LogoutEvent as AdminLogoutEvent;
use App\Modules\User\Events\LoginEvent as UserLoginEvent;
use App\Modules\User\Events\LogoutEvent as UserLogoutEvent;
use Seffeng\LaravelHelpers\Helpers\Arr;
use App\Common\Constants\FromConst;
use App\Common\Constants\TypeConst;
use App\Modules\Admin\Services\AdminService;
use App\Modules\User\Services\UserService;

class LoginLog
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
            $loginLogParams = $request->loginLogParams;
            $data = Arr::get($loginLogParams, 'data', []);
            $model = Arr::get($data, 'model', $this->getLoginUser($fromId));
            if ($model && $loginLogParams) {
                if (isset($data['model'])) {
                    unset($data['model']);
                }
                $typeId = Arr::get($loginLogParams, 'typeId');
                if ($this->isBackend($fromId)) {
                    if ($this->isLogout($typeId)) {
                        event(new AdminLogoutEvent($model, Arr::merge($data, ['fromId' => $fromId, 'clientIp' => $request->getClientIp()])));
                    } else {
                        event(new AdminLoginEvent($model, Arr::merge($data, ['fromId' => $fromId, 'clientIp' => $request->getClientIp()])));
                    }
                } else {
                    if ($this->isLogout($typeId)) {
                        event(new UserLogoutEvent($model, Arr::merge($data, ['fromId' => $fromId, 'clientIp' => $request->getClientIp()])));
                    } else {
                        event(new UserLoginEvent($model, Arr::merge($data, ['fromId' => $fromId, 'clientIp' => $request->getClientIp()])));
                    }
                }
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
     * @param  int $typeId
     * @return bool
     */
    private function isLogout(int $typeId)
    {
        return $typeId === TypeConst::LOG_LOGOUT;
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
