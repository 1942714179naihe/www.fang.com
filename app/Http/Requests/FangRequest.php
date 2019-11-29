<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fang_province' => 'required|numeric|min:1',
            'fang_name' => 'required',
            'fang_desn' => 'required',
            'fang_xiaoqu' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fang_province.required' => '必须填铁子',
            'fang_province.min'  => '选择个省铁子',
            'fang_name.required' => '房源名必须填',
            'fang_desn.required' => '请填写房源描述',
            'fang_xiaoqu.required' => '请填写小区',
        ];
    }
}
