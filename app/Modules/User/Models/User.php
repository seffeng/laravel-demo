<?php

namespace App\Modules\User\Models;

use App\Common\Base\Model;
use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;
use App\Modules\User\Illuminate\UserStatus;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Seffeng\Basics\Traits\DeleteTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 *
 * @date    2019年9月25日
 * @property integer $id
 * @property string $username
 * @property integer $status_id
 * @property integer $delete_id
 * @method static User byId(int $id)
 * @method static User byUsername(string $username)
 * @method static User likeUsername(string $username, bool $left = false)
 */
class User extends Model implements AuthenticatableContracts, JWTSubject
{
    use Authenticatable, DeleteTrait;

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
     *
     * @var array
     */
    protected $casts = [
        'login_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

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
    public function updateLoginValues(string $ipAddress = '')
    {
        $this->setAttribute('login_at', $this->freshTimestampString());
        $this->setAttribute('login_count', $this->login_count + 1);
        $this->setAttribute('login_ip', $ipAddress);
    }

    /**
     *
     * @author zxf
     * @date   2023-03-28
     * @return static
     */
    public function loadDefaultValue()
    {
        $this->setAttribute('status_id', StatusConst::NORMAL);
        $this->setAttribute('delete_id', DeleteConst::NOT);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2023-03-28
     * @param Builder $query
     * @param integer $id
     * @return static
     */
    public function scopeById(Builder $query, int $id)
    {
        return $query->where($this->qualifyColumn('id'), $id);
    }

    /**
     *
     * @author zxf
     * @date   2023-03-28
     * @param Builder $query
     * @param string $username
     * @return static
     */
    public function scopeByUsername(Builder $query, string $username)
    {
        return $query->where($this->qualifyColumn('username'), $username);
    }

    /**
     *
     * @author zxf
     * @date   2023-03-28
     * @param Builder $query
     * @param string $username
     * @param boolean $left
     * @return static
     */
    public function scopeLikeUsername(Builder $query, string $username, bool $left = false)
    {
        return $query->where($this->qualifyColumn('username'), 'like', ($left ? '%' : ''). $username .'%');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
