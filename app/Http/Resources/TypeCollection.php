<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        /**
         * 使用集合transform方法將每一筆資料一個一個處理，使用一個匿名函數，傳入一個$type參數
         * 這裡代表單一分類所以使用$type單數命名，函數中回傳一個陣列，將每一筆分類資料都使用這
         * 個陣列的格式轉換。
         * 參考網址:https://laravel.com/docs/8.x/collections#method-transform
         */
        return [
            'data' =>$this->collection->transform(function ($type){
                return [
                    'id' => $type->id,
                    'name' =>$type->name,
                    'sort' =>$type->sort, 
                ];
            })
        ];
    }
}
