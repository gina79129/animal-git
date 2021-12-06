<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        /**
         * 為達到更好的擴充性，可提供版號到URI裡
         */
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api/v1')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('api/v2')
                ->middleware('api')
                ->group(base_path('routes/apiV2.php'));

            // Route::prefix('api')
            //     ->middleware('api')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/api.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        /**
         * 主要的目的是限制客戶端一定時間內只能請求幾次API，註冊中介層檔案app\Http\Kernel.php中的$middlewareGroups
         * 屬性的api群組裡面有一個throttle:api中介層設定，用於限制請求次數，可以對應如下檔案，有定義一個api路由的限制，
         * 預設一分鐘內可以請求60次
         * 使用postman查看動物列表的api，點選回應的標頭資訊，分別會有X-RateLimit-Limit(請求次數)、X-RateLimit-Remaining(剩餘次數)
         * Retry-After(重置秒數)，當剩餘0次時，狀態碼回傳429 Too Many Requests(請求太多次的狀態)
         */
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
