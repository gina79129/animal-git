<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
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
            'type_id' =>'nullable|exists:types,id', //客戶端的type_id必須存在分類資料表中，反之不存在types資料表將不允許新增以及修改，並回應type_id不是有效的資料
            'name' =>'string|max:255', //文字類型最多255字元
            'birthday' => 'nullable|date', //允許null或日期格式
            'area' => 'nullable|string|max:255', //允許null或文字最多255字元
            'fix' => 'boolean', //若填寫並須是布林值
            'description' => 'nullable|string', //允許null或文字
            'personality' => 'nullable|string' //允許null或文字
        ];
    }
}
