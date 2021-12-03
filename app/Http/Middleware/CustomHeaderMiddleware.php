<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomHeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $headerName = 'X-Name',$headerValue='API')
    {
        $response=$next($request); //controller處理完成後的回應資料
        $response->headers->set($headerName,$headerValue);
        return $response;
        /**
         * 如上範例handle方法中撰寫，應用層controller處理完成資料以後，加上自訂標頭再回傳
         * 給客戶端，中介層設定分別有前置處理或後置處理，後置如上範例，前置可以參考官方文件，
         * 主要用於進入應用程式前對HTTP請求做判斷的動作
         * https://laravel.com/docs/8.x/middleware
         */
        
    }
}
