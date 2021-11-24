<?php

namespace App\Traits;

trait ApiResponseTrait{
    /**
     * 定義統一例外回應方法
     * 
     * @param mixed $message 錯誤訊息
     * @param mixed $status HTTP狀態碼
     * @param mixed|null $code 選項，自訂義錯誤編碼
     * @return \Illuminate\Http\response
     */

     public function errorResponse($message,$status,$code = null){
        //  dd($message,$status,$code);
         $code = $code ?? $status; //$code為null時預設Http狀態碼
         return response()->json(
             [
             'message' => $message,
             'code' => $code
            ],
         $status
        );
    }
}


?>