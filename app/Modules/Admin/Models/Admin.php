<?php

namespace App\Modules\Admin\Models;

use App\Common\Base\Model;
use App\Modules\Admin\Illuminate\AdminStatus;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Auth\Authenticatable;
use App\Common\Constants\StatusConst;
use App\Common\Constants\DeleteConst;
use Illuminate\Database\Eloquent\Builder;
use Seffeng\Basics\Traits\DeleteTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 * @date     2026-08-27
 * @property int $id
 * @property string $username
 * @property int $status_id
 * @property int $delete_id
 * @method Admin byId(int|array $id)
 * @method Admin byUsername(string $username)
 * @method Admin likeUsername(string $username, bool $left = false)
 * @method Admin byStatusId(int|array $statusId)
 * @method Admin byStatusOn()
 * @method Admin byStatusOff()
 */
class Admin extends Model implements AuthenticatableContracts, JWTSubject
{
    use Authenticatable, DeleteTrait;

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
     * @date    2026-08-27
     */
    public function encryptPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->password;
    }

    /**
     * 密码验证
     * @date   2026-08-27
     * @param  string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     *
     * @date    2026-08-27
     * @return  AdminStatus
     */
    public function getStatus()
    {
        return new AdminStatus($this->status_id);
    }

    /**
     * 更新登录信息
     * @author zxf
     * @date   2026-08-27
     * @param  string $ipAddress
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
     * @date    2026-08-27
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
     * @date   2026-08-27
     */
    public function onAdmin()
    {
        $this->setAttribute('status_id', StatusConst::NORMAL);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     */
    public function offAdmin()
    {
        $this->setAttribute('status_id', StatusConst::LOCK);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int|array $id
     * @return static
     */
    public function scopeById(Builder $query, $id)
    {
        if (is_array($id)) {
            return $query->whereIn($this->qualifyColumn('id'), $id);
        }
        return $query->where($this->qualifyColumn('id'), intval($id));
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  string $username
     * @return static
     */
    public function scopeByUsername(Builder $query, string $username)
    {
        return $query->where($this->qualifyColumn('username'), $username);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  string $username
     * @param  bool $left
     * @return static
     */
    public function scopeLikeUsername(Builder $query, string $username, bool $left = false)
    {
        return $query->where($this->qualifyColumn('username'), 'like', ($left ? '%' : ''). $username .'%');
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int|array $statusId
     * @return static
     */
    public function scopeByStatusId(Builder $query, $statusId)
    {
        if (is_array($statusId)) {
            return $query->whereIn($this->qualifyColumn('status_id'), $statusId);
        }
        return $query->where($this->qualifyColumn('status_id'), intval($statusId));
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @return static
     */
    public function scopeByStatusOn(Builder $query)
    {
        return $this->scopeByStatusId($query, StatusConst::NORMAL);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @return static
     */
    public function scopeByStatusOff(Builder $query)
    {
        return $this->scopeByStatusId($query, StatusConst::LOCK);
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
