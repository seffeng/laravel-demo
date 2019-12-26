<?php

namespace App\Modules\User\Models;

use App\Common\Base\Model;
use App\Modules\User\Illuminate\UserStatus;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Auth\Authenticatable;
/**
 *
 * @date    2019年9月25日
 * @property integer $id
 * @property string $username
 * @property integer $status_id
 * @property integer $delete_id
 */
class User extends Model implements AuthenticatableContracts
{
    use Authenticatable;

    /**
     *
     * @var string
     */
    protected $table = 'user';

    /**
     *
     * @var array
     */
    protected $fillable = ['username', 'password'];

    /**
     * 密码加密
     * @date    2019年7月30日
     */
    public function encryptPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        return $this->password;
    }

    /**
     * 密码验证
     * @date    2019年7月30日
     * @param  string $password
     * @return boolean
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     *
     * @date    2019年9月29日
     * @return \App\Modules\User\Illuminate\UserStatus
     */
    public function getStatus()
    {
        return new UserStatus($this->status_id);
    }

    /**
     * 更新登录信息
     * @author zxf
     * @date    2019年10月21日
     * @param string $ipAddress
     */
    public function updateLoginValues()
    {
        $this->login_at = time();
        $this->login_count += 1;
        $this->login_ip = ip2long(request()->ip());
    }
}
