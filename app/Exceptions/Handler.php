<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * render 方法分別傳入$request 使用者請求資料以及發生例外的$exception 資料
     */
    public function render($request, Throwable $exception){
        // dd($exception);
        if($request->expectsJson()){
        //如果使用者請求伺服器回傳JSON格式，就執行以下程式  (在使用postman時 加入Accept:application/json，就是在跟API伺服器說，請回傳JSON格式給我)
        //instanceof(型態運算子) 檢查$exception這個被攔截到的例外是不是ModelNotFoundException類別
            if($exception instanceof ModelNotFoundException){
                //攔截到例外，做出對應的處理，回傳404 Not Found 狀態碼，並附上錯誤資訊優化操作API上的體驗
                return response()->json([
                    'code' => '404',
                    'message' => '找不到資源',
                    'description' => '此資料已經刪除或不存在'
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
        }
        return parent::render($request,$exception);
    }
}
