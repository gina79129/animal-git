<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Animal\AnimalController;
use App\Http\Controllers\Api\V2\Animal\AnimalLikeController;
use App\Http\Controllers\Api\V2\Type\TypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * 這是預留給日後更新、維運使用的，正式上線有使用者的回饋，並且變動到請求回應的資料格式，
 * 會破壞原本V1版本，建議另建一個Api/V2 資料夾如下方指令新建Controller撰寫新版的方法
 * 
 * php artisan make:controller Api\V2\Animal\AnimalController --model=Animal
 */


// Route::apiResource('animals',AnimalController::class);
// Route::apiResource('types',TypeController::class);
// Route::middleware(['auth:api','scope:user-info'])->get('/user',function(Request $request){
//     return $request->user();
// });
// Route::apiResource('animals.likes',AnimalLikeController::class)->only(['index','store']);
