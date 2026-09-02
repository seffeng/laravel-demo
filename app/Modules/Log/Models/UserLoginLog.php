<?php
namespace App\Modules\Log\Models;

use App\Common\Base\Model;
use App\Modules\Log\Illuminate\LoginLogType;
use App\Modules\Log\Illuminate\LogFrom;
use App\Modules\Log\Illuminate\LogStatus;
use App\Common\Constants\DeleteConst;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\User\Models\User;
use Seffeng\Basics\Traits\DeleteTrait;

/**
 *
 * @author zxf
 * @date   2026-08-27
 * @method UserLoginLog byId(int $id)
 * @method UserLoginLog byStatusId(int $statusId)
 * @method UserLoginLog byTypeId(int $typeId)
 * @method UserLoginLog byFromId(int $fromId)
 * @method UserLoginLog byUserId(int $userId)
 */
class UserLoginLog extends Model
{
    use DeleteTrait;

    /**
     *
     * @var string
     */
    protected $table = 'user_login_log';

    /**
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status_id', 'type_id', 'from_id', 'login_ip', 'content'];

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return LoginLogType
     */
    public function getType()
    {
        return new LoginLogType($this->type_id);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return \App\Modules\Log\Illuminate\LogFrom
     */
    public function getFrom()
    {
        return new LogFrom($this->from_id);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return LogStatus
     */
    public function getStatus()
    {
        return new LogStatus($this->status_id);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\Model::loadDefaultValue()
     */
    public function loadDefaultValue()
    {
        $this->setAttribute('delete_id', DeleteConst::NOT);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeById(Builder $query, int $id)
    {
        return $query->where($this->qualifyColumn('id'), $id);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int $statusId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatusId(Builder $query, int $statusId)
    {
        return $query->where($this->qualifyColumn('status_id'), $statusId);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUserId(Builder $query, int $userId)
    {
        return $query->where($this->qualifyColumn('user_id'), $userId);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int $typeId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTypeId(Builder $query, int $typeId)
    {
        return $query->where($this->qualifyColumn('type_id'), $typeId);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  Builder $query
     * @param  int $fromId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFromId(Builder $query, int $fromId)
    {
        return $query->where($this->qualifyColumn('from_id'), $fromId);
    }
}
