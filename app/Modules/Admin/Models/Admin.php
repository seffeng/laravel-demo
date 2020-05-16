<?php

namespace App\Modules\Admin\Models;

use App\Common\Base\Model;
use App\Modules\Admin\Illuminate\AdminStatus;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Auth\Authenticatable;
use App\Common\Constants\StatusConst;
use App\Common\Constants\DeleteConst;
use Illuminate\Database\Eloquent\Builder;
/**
 *
 * @date    2019年9月25日
 * @property integer $id
 * @property string $username
 * @property integer $status_id
 * @property integer $delete_id
 * @method Admin byId(int $id)
 * @method Admin byUsername(string $username)
 * @method Admin likeUsername(string $username, bool $left = false)
 * @method Admin notDelete()
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
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
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

    /**
     *
     * @author zxf
     * @date   2020年4月3日
     * @param Builder $query
     * @param int $id
     * @return Admin
     */
    public function scopeById(Builder $query, int $id)
    {
        return $query->where('id', $id);
    }

    /**
     *
     * @author zxf
     * @date    2020年4月3日
     * @param  Builder $query
     * @param  string $username
     * @return Admin
     */
    public function scopeByUsername(Builder $query, string $username)
    {
        return $query->where('username', $username);
    }

    /**
     *
     * @author zxf
     * @date   2020年4月3日
     * @param Builder $query
     * @param string $username
     * @param boolean $left
     * @return Admin
     */
    public function scopeLikeUsername(Builder $query, string $username, bool $left = false)
    {
        return $query->where('username', 'like', ($left ? '%' : ''). $username .'%');
    }

    /**
     *
     * @author zxf
     * @date   2020年4月3日
     * @param  Builder $query
     * @return Admin
     */
    public function scopeNotDelete(Builder $query)
    {
        return $query->where('delete_id', DeleteConst::NOT);
    }
}
