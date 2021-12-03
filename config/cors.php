<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    /**
     * CORS => Cross-Origin Resource Sharing (跨來源資源共用)
     */
    //允許CORS的路徑設應
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    //允許的HTTP動詞，如果允許POST動詞但不允許PUT或PATCH，客戶端還是可以使用POST加上內容 _method的方式請求
    'allowed_methods' => ['*'],
    //允許的來源網址，只允許哪些網域使用跨域請求
    'allowed_origins' => ['*'],
    //將請求來源與正則表達式匹配preg_match
    'allowed_origins_patterns' => [],
    //允許的標頭，如果有使用自訂標頭，需要allowed_headers中添加標頭，或使用「*」星號來允許所有定義標頭
    'allowed_headers' => ['*'],

    'exposed_headers' => [],
    //快取最大的時間，預設為0表示API回傳資料以後0秒過期
    'max_age' => 0,
    //設置Access-Control-Allow-Credentials標頭
    'supports_credentials' => false,

];
