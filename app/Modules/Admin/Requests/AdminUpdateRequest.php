<?php

namespace App\Modules\Admin\Requests;

use App\Common\Base\FormRequest;
use App\Common\Rules\Phone;
use Illuminate\Validation\Rule;
use App\Modules\Admin\Models\Admin;
use App\Common\Constants\DeleteConst;
/**
 *
 * @author zxf
 * @date    2019年10月29日
 * @property int $id
 * @property int $password
 * @property string $phone
 */
class AdminUpdateRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'password', 'phone'];

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::rules()
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'phone' => [
                'required',
                'min:11',
                'max:11',
                new Phone(),
                Rule::unique((new Admin())->getTable())->where(function ($query) {
                    return $query->where('id', '<>', intval(request('id')))->where('delete_id', DeleteConst::NOT);
                })
            ],
            'password' => [
                'required',
                'between:6,20',
                'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/',
            ],
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'required' => ':attribute不能为空！',
            'min' => ':attribute至少:min位字符！',
            'max' => ':attribute最多:max位字符！',
            'between' => ':attribute必须:min~:max位字符！',
            'unique' => ':attribute已存在！',
            'regex' => ':attribute必须包含字母和数字的6~20位字符！',
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::attributes()
     */
    public function attributes()
    {
        return [
            'id' => 'ID',
            'phone' => '手机号',
            'password' => '密码',
        ];
    }
}
