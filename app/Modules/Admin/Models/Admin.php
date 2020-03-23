<?php

namespace App\Modules\Admin\Models;

use App\Common\Base\Model;
use App\Modules\Admin\Illuminate\AdminStatus;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Auth\Authenticatable;
use App\Common\Constants\StatusConst;
use App\Common\Constants\DeleteConst;
/**
 *
 * @date    2019年9月25日
 * @property integer $id
 * @property string $username
 * @property integer $status_id
 * @property integer $delete_id
 */
class Admin extends Model implements AuthenticatableContracts
{
    use Authenticatable;

    /**
     *
     * @var string
     */
    protected $table = 'admin';

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
     * @return AdminStatus
     */
    public function getStatus()
    {
        return new AdminStatus($this->status_id);
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

    /**
     *
     * @author zxf
     * @date    2019年10月29日
     */
    public function loadDefaultValue()
    {
        $this->setAttribute('status_id', StatusConst::NORMAL);
        $this->setAttribute('delete_id', DeleteConst::NOT);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Illuminate\Database\Eloquent\Model::delete()
     */
    public function delete()
    {
        $this->delete_id = DeleteConst::YES;
    }
}
