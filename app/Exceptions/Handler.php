<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */

    use ApiResponseTrait;
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
        //model找不到資源    
        if($request->expectsJson()){
        //如果使用者請求伺服器回傳JSON格式，就執行以下程式  (在使用postman時 加入Accept:application/json，就是在跟API伺服器說，請回傳JSON格式給我)
        //instanceof(型態運算子) 檢查$exception這個被攔截到的例外是不是ModelNotFoundException類別
            if($exception instanceof ModelNotFoundException){
                //攔截到例外，做出對應的處理，回傳404 Not Found 狀態碼，並附上錯誤資訊優化操作API上的體驗
                //呼叫Trait 的 errorResponse 方法
                // return response()->json([
                //     'error'=>'找不要資源'
                // ],Response::HTTP_NOT_FOUND);
                return $this->errorResponse(
                    '找不到資源',
                    Response::HTTP_NOT_FOUND
                );
            }
            
            //網址輸入錯誤
            if($exception instanceof NotFoundHttpException){
                return $this->errorResponse(
                    '無法找到此網址',
                    Response::HTTP_NOT_FOUND
                );
            }
            //網址不允許該請求動詞
            if($exception instanceof MethodNotAllowedHttpException){
                return $this->errorResponse(
                    $exception->getMessage(),
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
        }
        return parent::render($request,$exception);
    }
}
