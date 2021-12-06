<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreAnimalRequest 將AnimalController的store 驗證改由request StoreAnimalRequest
 */
class StoreAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * 是否有權限可以操作
     * 可以在方法中撰寫是否能操作新建動物請求的邏輯判斷
     * 
     * @return bool
     */
    public function authorize()
    {
        //修改為true，預設為false會永遠顯示403無權限的提示
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * 請求的資料欄位規則
     * 
     * @return array
     */
    public function rules()
    {
        /**
         * 將app\Http\Controllers\AnimalController.php檔案中
         * store方法的驗證表單規則複製過來
         */
        return [
            'type_id' =>'nullable|exists:types,id', //客戶端的type_id必須存在分類資料表中，反之不存在types資料表將不允許新增以及修改，並回應type_id不是有效的資料
            'name' =>'required|string|max:255', //必填文字最多255字元
            'birthday' => 'nullable|date', //允許null或日期格式，使用PHP strtotime檢查傳入的日期字串
            'area' => 'nullable|string|max:255', //允許null或文字最多255字元
            'fix' => 'required|boolean', //必填並且為布林值
            'description' => 'nullable', //允許null
            'personality' => 'nullable' //允許null
        ];
    }
}
