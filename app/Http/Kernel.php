<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    //全域的HTTP請求都經過這一個地方設定的中介層，可以看到其中已經有很多的預設中介層，由上到下依序執行
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    /**
     * Laravel5.2版本以後加入的中介層群組，將多個中介層包裝在這個陣列中，可以看到web以及api，
     * web群組有很多中介層，包含cookies、Session、CSRF...，routes\web.php檔案中設定的路由，
     * 套用這個群組的中介層，另外API的部分道理相同，api群組中有一個字串throttle:api利用下一點
     * 註冊指派路由中介層的名詞方式使用
     */

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //同步授權 一定要最後一個
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
            /**
             * 如上範例該Passport中介層會將XSRF-TOKEN的cookie使用Set-Cookie附加到任何網頁回應中，
             * 因此使用Laravel製作前端網頁，在同一份專案中，使用預設的JavaScript axios套件發送請求
             * 時，會一併將這個cookie使用X-XSRF-TOKEN標頭送回API，因此可不用任何設定，只要會員登入
             * 狀態就可以在後端進行比對直接使用API
             */

        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            //放在第一個先處理，由上到下執行，如果任一個未通過將不會加上自訂標頭
            'custom.header:X-Application-Name,Victor RESTful API',
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */

     /**
      * 定義一個名詞呼叫中介層用於指派給路由使用，使用$this->middleware('auth:api')設定中
      * 介層讓API必須要驗證才可以使用
      */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
        'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
        //客戶端憑證授權
        'client' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
        'custom.header' => \App\Http\Middleware\CustomHeaderMiddleware::class,
    ];
    /**
     * Passport有提供兩個中介層，用於驗證傳入Token是否擁有該Scope權限
     * scopes 中介層 檢查所有Scope都被允許
     * scope 中介層 檢查至少有一個Scope允許
     */
}
