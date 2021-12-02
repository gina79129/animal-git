<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        //access_token 設定核發後15天後過期
        Passport::tokensExpireIn(now()->addDays(15));

        //refresh_token 設定核發後30天後過期
        Passport::refreshTokensExpireIn(now()->addDays(30));
        /**
         * 時間越短安全性越高，如密碼授權的方式，不斷的發送請求內容還包含帳號密碼也會增加
         * 安全上的疑慮，因此只要refresh_token還沒過期，就可以使用它刷新access_token
         */

         /**
          * 授權客戶端讀取會員資料，幫會員新增文章...不同範圍的功能，這就是由SCOPE控制，
          * 客戶端請求Token時，可以選填SCOPE這個值，授權碼授權時會顯示於授權畫面，使用者
          * 按下確認，客戶端就可以拿到Token操作SCOPE這些範圍的API
          */

          /**
           * AuthServiceProvider的boot方法中使用Passport::tokensCan定義伺服器的SCOPE，
           * tokensCan中填入陣列key表示SCOPE名稱，value表示SCOPE的說明。
           * 只有密碼授權及客戶端憑證授權可以使用「*」允許所有SCOPE的操作。
           */
         Passport::tokensCan([
             'create-animals' => '建立動物資訊',
             'user-info' => '使用者資訊',
         ]);
    }
}
