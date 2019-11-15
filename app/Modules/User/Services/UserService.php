<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use App\Modules\User\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Exceptions\UserStatusException;
use App\Modules\User\Events\LoginEvent;
use App\Common\Constants\DeleteConst;

class UserService
{
    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param  string $username
     * @return User
     */
    public function getUserByUsername(string $username)
    {
        return User::where('username', $username)->where('delete_id', DeleteConst::NOT)->first();
    }

    /**
     *
     * @author zxf
     * @date   2019年10月19日
     * @param  string $username
     * @throws UserNotFoundException
     * @throws \Exception
     * @return \App\Modules\User\Models\User
     */
    public function notNullByUsername(string $username)
    {
        try {
            $model = $this->getUserByUsername($username);
            if ($model) {
                return $model;
            }
            throw new UserNotFoundException('用户不存在！');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param string $username
     * @param string $password
     * @param bool $remember
     * @throws UserException
     * @throws UserStatusException
     * @throws UserNotFoundException
     * @throws \Exception
     * @return boolean
     */
    public function userLogin(string $username, string $password, bool $remember = false)
    {
        try {
            $userItem = $this->notNullByUsername($username);
            if ($userItem->getStatus()->getIsNormal()) {
                if ($userItem->verifyPassword($password)) {
                    $this->getAuthGuard()->login($userItem, $remember);
                    event(new LoginEvent($userItem));
                    return $this->userIsLogin();
                }
                throw new UserException('账号或密码错误！');
            }
            throw new UserStatusException('该账号已禁用！');
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundException('账号或密码错误！');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     */
    public function userLogout()
    {
        return $this->getAuthGuard()->logout();
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return boolean
     */
    public function userIsLogin()
    {
        return $this->getAuthGuard()->check();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return \Illuminate\Contracts\Auth\Authenticatable|NULL
     */
    public function getLoginUser()
    {
        return $this->getAuthGuard()->user();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return NULL[]|array
     */
    public function getLoginUserToArray()
    {
        $user = $this->getLoginUser();
        if ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
            ];
        }
        return [];
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function getAuthGuard()
    {
        return Auth::guard('www');
    }
}
