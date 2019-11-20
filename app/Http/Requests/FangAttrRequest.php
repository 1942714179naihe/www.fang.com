<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

class FangAttrRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    // 验证
    public function rules() {
        // 调用一次自定义规则 只要在rules验证之前
        $this->fieldName();

        return [
            'name' => 'required',
            'field_name' => 'fieldname'
        ];
    }

    public function messages() {
        return [
            'field_name.fieldname' => '选择顶级属性必须要填写对应的字段名称'
        ];
    }

    // 自定义验证规则
    public function fieldName() {
        // 自定义验证器名称
        Validator::extend('fieldname', function ($attribute, $value, $parameters, $validator) {
            $pid = request()->get('pid');
            $bool = $pid == 0 ? false : true;
            $reg = '/\w+/';
            return $bool || preg_match($reg, $value);
        });
    }
}
