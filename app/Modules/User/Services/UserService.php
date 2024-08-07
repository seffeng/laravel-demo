<?php

namespace App\Modules\User\Services;

use App\Common\Base\Service;
use App\Common\Constants\FromConst;
use App\Common\Constants\ModuleConst;
use App\Common\Constants\StatusConst;
use App\Common\Constants\TypeConst;
use App\Modules\User\Models\User;
use App\Modules\User\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Exceptions\UserStatusException;
use App\Modules\User\Requests\UserUpdateRequest;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Common\Exceptions\BaseException;
use App\Modules\User\Exceptions\UserPasswordException;
use App\Modules\User\Requests\UserCreateRequest;
use App\Modules\User\Requests\UserDeleteRequest;
use App\Modules\User\Requests\UserLoginRequest;
use App\Modules\User\Requests\UserSearchRequest;
use App\Modules\User\Requests\UserStatusRequest;
use Illuminate\Support\Facades\Date;

class UserService extends Service
{
    /**
     *
     * @var string
     */
    private $auth = FromConst::FRONTEND_NAME;

    /**
     *
     * @author zxf
     * @date    2019年12月26日
     * @param  int $id
     * @return User
     */
    public function getUserById(int $id)
    {
        return User::byId($id)->first();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param  int $id
     * @throws UserNotFoundException
     * @throws \Exception
     * @return User
     */
    public function notNullById(int $id)
    {
        try {
            $model = $this->getUserById($id);
            if ($model) {
                return $model;
            }
            throw new UserNotFoundException(trans('user.notFound'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param  string $username
     * @return User
     */
    public function getUserByUsername(string $username)
    {
        return User::byUsername($username)->first();
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
            throw new UserNotFoundException(trans('user.notFound'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param UserLoginRequest $form
     * @throws UserException
     * @throws UserStatusException
     * @throws UserNotFoundException
     * @throws \Exception
     * @return boolean
     */
    public function userLogin(UserLoginRequest $form)
    {
        try {
            $userItem = $this->notNullByUsername($form->getFillItems('username'));
            if ($userItem->getStatus()->getIsNormal()) {
                if ($userItem->verifyPassword($form->getFillItems('password'))) {
                    $token = $this->getAuthGuard()->login($userItem, $form->getFillItems('remember'));
                    $form->setLoginLogParams(TypeConst::LOG_LOGIN, ModuleConst::USER);
                    return $token;
                }
                $form->setLoginLogParams(TypeConst::LOG_LOGIN, ModuleConst::USER, [
                    'model' => $userItem,
                    'statusId' => StatusConst::FAILD
                ]);
                throw new UserPasswordException(trans('user.passError'));
            }
            throw new UserStatusException(trans('user.locked'));
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundException(trans('user.passError'));
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
        try {
            $this->getAuthGuard()->logout();
            return true;
        } catch (TokenExpiredException $e) {
            return true;
        } catch (JWTException $e) {
            throw new BaseException($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
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
     * @date    2019年12月26日
     * @param  UserUpdateRequest $form
     * @param  boolean $assoc
     * @throws \Exception
     * @return boolean|User
     */
    public function updateUser(UserUpdateRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                $password = $form->getFillItems('password');
                $model->fill([
                    'username' => $form->getFillItems('username'),
                ]);
                if ($password) {
                    $model->fill([
                        'password' => $form->getFillItems('password'),
                    ]);
                    $model->encryptPassword();
                }
                $diffChanges = $model->diffChanges(['username']);
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_UPDATE, ModuleConst::USER, $diffChanges);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new UserException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param UserDeleteRequest $form
     * @param boolean $assoc
     * @return boolean|User
     */
    public function deleteUser(UserDeleteRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                if ($model->delete()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_DELETE, ModuleConst::USER);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new UserException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param UserStatusRequest $form
     * @param boolean $assoc
     * @return boolean|User
     */
    public function onUser(UserStatusRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                if ($model->getStatus()->getIsNormal()) {
                    return $assoc ? $model : true;
                }
                $model->onUser();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_UNLOCK, ModuleConst::USER);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new UserException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param UserStatusRequest $form
     * @param boolean $assoc
     * @return boolean|User
     */
    public function offUser(UserStatusRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = $this->notNullById($form->getFillItems('id'));
                if (!$model->getStatus()->getIsNormal()) {
                    return $assoc ? $model : true;
                }
                $model->offUser();
                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_LOCK, ModuleConst::USER);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new UserException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2021年4月12日
     * @param UserSearchRequest $form
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserPaginate(UserSearchRequest $form)
    {
        /**
         *
         * @var User $query
         */
        $query = User::with($form->getWith());
        if ($id = $form->getFillItems('id')) {
            $query->byId($id);
        }
        if ($username = $form->getFillItems('username')) {
            $query->likeUsername($username);
        }
        if ($statusId = $form->getFillItems('statusId')) {
            $query->byStatusId($statusId);
        }
        if ($createdStartAt = $form->getFillItems('startAt')) {
            $query->where('created_at', '>=', Date::parse($createdStartAt)->format((new User())->getDateFormat()));
        }
        if ($createdEndAt = $form->getFillItems('endAt')) {
            $query->where('created_at', '<', Date::parse($createdEndAt)->addDay()->format((new User())->getDateFormat()));
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
     * @date    2021年4月12日
     * @param  UserSearchRequest $form
     * @return array
     */
    public function getUserStore(UserSearchRequest $form)
    {
        $paginator = $this->getUserPaginate($form);
        $items = [];
        /**
         *
         * @var User $model
         */
        if ($paginator) foreach ($paginator as $model) {
            $items[] = $this->filterByFillable([
                'id' => $model->id,
                'username' => $model->username,
                'status' => [
                    'id' => $model->status_id,
                    'name' => $model->getStatus()->getName(),
                    'isNormal' => $model->getStatus()->getIsNormal()
                ],
                'loginAt' => $model->login_at,
                'createdAt' => $model->created_at,
                'updatedAt' => $model->updated_at
            ]);
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date   2024-05-23
     * @param UserCreateRequest $form
     * @param boolean $assoc
     * @return User|boolean
     */
    public function createUser(UserCreateRequest $form, bool $assoc = false)
    {
        try {
            if ($form->getIsPass()) {
                $model = new User();
                $model->fill([
                    'username' => $form->getFillItems('username'),
                    'password' => $form->getFillItems('password'),
                ]);
                $model->encryptPassword();
                $model->loadDefaultValue();

                if ($model->save()) {
                    $form->setOperateLogParams($model, TypeConst::LOG_CREATE, ModuleConst::USER);
                    return $assoc ? $model : true;
                }
                return false;
            }
            throw new UserException(trans('common.validatorError'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年3月23日
     * @param string $auth
     */
    public function setAuth(string $auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2020年3月23日
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function getAuthGuard()
    {
        return Auth::guard($this->getAuth());
    }
}
