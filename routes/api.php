<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Animal\AnimalController;
use App\Http\Controllers\Api\V1\Animal\AnimalLikeController;
use App\Http\Controllers\Api\V1\Type\TypeController;

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


Route::apiResource('animals',AnimalController::class);
Route::apiResource('types',TypeController::class);
Route::middleware(['auth:api','scope:user-info'])->get('/user',function(Request $request){
    return $request->user();
});
Route::apiResource('animals.likes',AnimalLikeController::class)->only(['index','store']);
