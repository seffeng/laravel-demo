<?php

namespace App\Common\Base;

use Seffeng\LaravelHelpers\Helpers\Arr;

/**
 *
 * @author zxf
 * @date   2026-08-27
 */
class FormRequest extends \Seffeng\Basics\Base\FormRequest
{
    /**
     * fillable 参数格式
     * true-驼峰，false-下划线
     * 驼峰参数格式时$fillItems将同时存在驼峰和下划线两种值
     * @var bool
     */
    protected $isCamel = true;

    /**
     *
     * @var array
     */
    protected $operateLogParams = [];

    /**
     *
     * @var int
     */
    protected $loginLogTypeId;
    /**
     *
     * @var int
     */
    protected $loginLogModuleId;
    /**
     *
     * @var array
     */
    protected $loginLogData;

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::messages()
     */
    public function messages()
    {
        return Arr::merge(parent::messages(), [
            'required' => trans('common.required'),
            'min' => trans('common.min'),
            'max' => trans('common.max'),
            'between' => trans('common.between'),
            'unique' => trans('common.unique'),
            'integer' => trans('common.integer'),
            'string' => trans('common.string'),
            'in' => trans('common.in'),
        ]);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return array
     */
    public function getOperateLogParams()
    {
        return $this->operateLogParams;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param mixed $operateLogModel
     * @param int $operateLogTypeId
     * @param int $operateLogModuleId
     * @param array $operateLogDiffChanges
     */
    public function setOperateLogParams($operateLogModel, int $operateLogTypeId, int $operateLogModuleId, array $operateLogDiffChanges = [])
    {
        array_push($this->operateLogParams, [
            'model' => $operateLogModel,
            'typeId' => $operateLogTypeId,
            'moduleId' => $operateLogModuleId,
            'diffChanges' => $operateLogDiffChanges
        ]);
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param int $loginTypeId
     * @param int $loginLogModuleId
     */
    public function setLoginLogParams(int $loginTypeId, int $loginLogModuleId, array $data = [])
    {
        $this->loginLogTypeId = $loginTypeId;
        $this->loginLogModuleId = $loginLogModuleId;
        $this->loginLogData = $data;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return array
     */
    public function getLoginLogParams()
    {
        return $this->loginLogTypeId ? [
            'typeId' => $this->loginLogTypeId,
            'moduleId' => $this->loginLogModuleId,
            'data' => $this->loginLogData,
        ] : [];
    }
}
