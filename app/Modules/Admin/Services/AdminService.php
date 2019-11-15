<?php

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Exceptions\AdminNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Exceptions\AdminException;
use App\Modules\Admin\Exceptions\AdminStatusException;
use App\Modules\Admin\Events\LoginEvent;
use App\Common\Base\Service;
use App\Modules\Admin\Requests\AdminSearchRequest;
use App\Modules\Admin\Requests\AdminCreateRequest;
use App\Modules\Admin\Requests\AdminUpdateRequest;
use App\Common\Constants\DeleteConst;

class AdminService extends Service
{
    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param int $id
     * @return Admin
     */
    public function getAdminById(int $id)
    {
        return Admin::where('id', $id)->where('delete_id', DeleteConst::NOT)->first();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param int $id
     * @throws AdminNotFoundException
     * @throws \Exception
     * @return Admin
     */
    public function notNullById(int $id)
    {
        try {
            $model = $this->getAdminById($id);
            if ($model) {
                return $model;
            }
            throw new AdminNotFoundException('管理员不存在！');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param  string $phone
     * @return Admin
     */
    public function getAdminByPhone(string $phone)
    {
        return Admin::where('phone', $phone)->where('delete_id', DeleteConst::NOT)->first();
    }

    /**
     *
     * @author zxf
     * @date   2019年10月19日
     * @param  string $phone
     * @throws AdminNotFoundException
     * @throws \Exception
     * @return Admin
     */
    public function notNullByPhone(string $phone)
    {
        try {
            $model = $this->getAdminByPhone($phone);
            if ($model) {
                return $model;
            }
            throw new AdminNotFoundException('管理员不存在！');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @param string $phone
     * @param string $password
     * @param bool $remember
     * @throws AdminException
     * @throws AdminStatusException
     * @throws AdminNotFoundException
     * @throws \Exception
     * @return boolean
     */
    public function adminLogin(string $phone, string $password, bool $remember = false)
    {
        try {
            $userItem = $this->notNullByPhone($phone);
            if ($userItem->getStatus()->getIsNormal()) {
                if ($userItem->verifyPassword($password)) {
                    $this->getAuthGuard()->login($userItem, $remember);
                    event(new LoginEvent($userItem));
                    return $this->adminIsLogin();
                }
                throw new AdminException('账号或密码错误！');
            }
            throw new AdminStatusException('该账号已禁用！');
        } catch (AdminNotFoundException $e) {
            throw new AdminNotFoundException('账号或密码错误！');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     */
    public function adminLogout()
    {
        return $this->getAuthGuard()->logout();
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return boolean
     */
    public function adminIsLogin()
    {
        return $this->getAuthGuard()->check();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return \Illuminate\Contracts\Auth\Authenticatable|NULL
     */
    public function getLoginAdmin()
    {
        return $this->getAuthGuard()->user();
    }

    /**
     *
     * @author zxf
     * @date    2019年10月21日
     * @return NULL[]|array
     */
    public function getLoginAdminToArray()
    {
        $user = $this->getLoginAdmin();
        if ($user) {
            return [
                'id' => $user->id,
                'phone' => $user->phone,
            ];
        }
        return [];
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param  int $pageSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAdminPaginate(AdminSearchRequest $form, int $pageSize = 10)
    {
        $query = Admin::on();
        if ($form->id) {
            $query->where('id', $form->id);
        }
        if ($form->phone) {
            $query->where('phone', $form->phone);
        }
        return $query->orderBy('id', 'desc')->paginate($pageSize);
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @return array
     */
    public function getAdminStore(AdminSearchRequest $form, int $pageSize = 10)
    {
        $paginator = $this->getAdminPaginate($form, $pageSize);
        $items = [];
        if ($paginator) foreach ($paginator as $model) {
            $items[] = [
                'id' => $model->id,
                'phone' => $model->phone,
                'statusId' => $model->status_id,
                'statusName' => $model->getStatus()->getName(),
                'createDate' => date('Y-m-d H:i', $model->created_at),
            ];
        }
        return [
            'items' => $items,
            'page' => $this->getPaginate($paginator)
        ];
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param  AdminCreateRequest $form
     * @throws \Exception
     * @return boolean
     */
    public function createAdmin(AdminCreateRequest $form)
    {
        try {
            $model = new Admin();
            $model->fill([
                'phone' => $form->phone,
                'password' => $form->password,
            ]);
            $model->encryptPassword();
            $model->loadDefaultValue();
            return $model->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月30日
     * @param AdminUpdateRequest $form
     * @throws \Exception
     * @return boolean
     */
    public function updateAdmin(AdminUpdateRequest $form)
    {
        try {
            $model = $this->notNullById($form->id);
            $model->fill([
                'phone' => $form->phone,
                'password' => $form->password,
            ]);
            $model->encryptPassword();
            return $model->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     * @param  int $id
     * @throws \Exception
     * @return boolean
     */
    public function deleteAdmin(int $id)
    {
        try {
            $model = $this->notNullById($id);
            $model->delete();
            return $model->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date    2019年9月29日
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function getAuthGuard()
    {
        return Auth::guard('admin');
    }
}
