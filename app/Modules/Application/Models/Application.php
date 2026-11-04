<?php

namespace App\Modules\Application\Models;

use App\Common\Base\Model;
use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;
use App\Modules\Application\Illuminate\ApplicationStatus;
use Illuminate\Database\Eloquent\Builder;
use Seffeng\Basics\Traits\DeleteTrait;
use Seffeng\LaravelHelpers\Helpers\Str;

/**
 *
 * @author zxf
 * @date   2026-10-15
 * @method Application byId(int|array $id)
 * @method Application byName(string $name)
 * @method Application byStatusId(int|array $statusId)
 * @method Application byAppKey(string $appKey)
 */
class Application extends Model
{
    use DeleteTrait;

    /**
     *
     * @var int
     */
    protected $keyLength = 24;

    /**
     *
     * @var int
     */
    protected $secretLength = 64;

    /**
     * @author zxf
     * @date   2026-10-15
     * @var string
     */
    protected $table = 'application';

    /**
     * @author zxf
     * @date   2026-10-15
     * @var array
     */
    protected $fillable = ['name', 'app_key', 'app_secret', 'domain', 'allow_ip', 'deny_ip', 'description'];

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return static
     */
    public function loadDefaultValue()
    {
        $this->setAttribute('status_id', StatusConst::ON);
        $this->setAttribute('delete_id', DeleteConst::NOT);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return ApplicationStatus
     */
    public function getStatus()
    {
        return new ApplicationStatus($this->status_id);
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return static
     */
    public function generateAppKey()
    {
        $exists = false;
        $i = 1;
        do {
            $appKey = Str::generateChatCode($this->keyLength, true);
            $exists = static::byAppKey($appKey)->withTrashed()->exists();
            $i++;
            if ($i > 100) {
                break;
            }
        } while ($exists);
        $this->setAttribute('app_key', $appKey);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return static
     */
    public function generateAppSecret()
    {
        $this->setAttribute('app_secret', Str::generateStringCode($this->secretLength));
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return static
     */
    public function onApplication()
    {
        $this->setAttribute('status_id', StatusConst::ON);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return static
     */
    public function offApplication()
    {
        $this->setAttribute('status_id', StatusConst::OFF);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return array
     */
    public function getAllowIpsAttribute()
    {
        try {
            if ($this->allow_ip) {
                return Str::toArray($this->allow_ip, ',', ' ');
            }
        } catch (\Exception $e) {
            //
        }
        return [];
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return array
     */
    public function getDenyIpsAttribute()
    {
        try {
            if ($this->deny_ip) {
                return Str::toArray($this->deny_ip, ',', ' ');
            }
        } catch (\Exception $e) {
            //
        }
        return [];
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
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
     * @date   2026-10-15
     * @param  Builder $query
     * @param  string $name
     * @return static
     */
    public function scopeByName(Builder $query, string $name)
    {
        return $query->where($this->qualifyColumn('name'), $name);
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
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
     * @date   2026-10-15
     * @param  Builder $query
     * @param  string $appKey
     * @return static
     */
    public function scopeByAppKey(Builder $query, string $appKey)
    {
        return $query->where($this->qualifyColumn('app_key'), $appKey);
    }
}
