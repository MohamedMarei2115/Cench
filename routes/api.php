<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CardController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RankPointController;
use App\Http\Controllers\UserPointsController;
use App\Models\UserPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('api')->group(function () {
//    Route::prefix('user/')->group(function () {
//        Route::post('/register', [UserController::class, 'register']);
////    Route::post('/create', [MovieController::class, 'store'])->name('movies.create');
////    Route::post('/update', [MovieController::class, 'update'])->name('movies.update');
////    Route::post('/delete', [MovieController::class, 'destroy'])->name('movies.delete');
//    });
//});

Route::prefix('user/')->group(function () {
//    Route::post('/register', [AuthController::class, 'register']);
//    Route::post('/login', [AuthController::class, 'login']);
//    Route::post('/activeAccount', [AuthController::class, 'activeAccount']);
//    Route::post('/resendCode', [AuthController::class, 'resendCode']);
//    Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);
//    Route::post('/verifyCode', [AuthController::class, 'verifyCode']);
//    Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
//    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//    Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
//
//
//    Route::get('/points', [UserPointsController::class, 'getUserPoints'])->middleware('auth:sanctum');
//
//
//
//    Route::prefix('rank')->middleware('auth:sanctum')->group(function (){
//        Route::get('/overAllUser',[RankPointController::class,'overAllUser']);
//        Route::get('/appWeekRankUser',[RankPointController::class,'appWeekRankUser']);
//        Route::get('/weekRankUser',[RankPointController::class,'weekRankUSer']);
//        Route::get('/monthlyRankUser',[RankPointController::class,'monthlyRankUser']);
//    });

    Route::prefix('order')->group(function (){
        Route::post('/store',[OrderController::class,'store']);
//        Route::get('/appWeekRankTop',[RankPointController::class,'appWeekRankTop']);
//        Route::get('/weekRankTop',[RankPointController::class,'weekRankTop']);
//        Route::get('/monthlyRankTop',[RankPointController::class,'monthlyRankTop']);
    });

//    Route::post('/testAuth', [AuthController::class, 'testAuth'])->middleware('auth:sanctum');
});

Route::prefix('product')->group(function (){
    Route::get('/getAll',[ProductController::class,'getAll']);
//    Route::get('/detail/{id}',[AvatarController::class,'avatarDetail']);
});

//Route::prefix('event')->group(function (){
//    Route::get('/',[CategoryController::class,'getAll']);
//    Route::get('/detail/{id}',[CategoryController::class,'eventDetail']);
//});
//
//Route::prefix('media')->group(function (){
//    Route::post('/',[MediaController::class,'getMedia']);
////    Route::get('/detail/{id}',[CategoryController::class,'eventDetail']);
//});
//
//Route::middleware('auth:sanctum')->prefix('card')->group(function (){
//    Route::get('/index',[CardController::class,'index']);
//    Route::post('/create',[CardController::class,'store']);
//    Route::post('/update',[CardController::class,'update']);
//    Route::post('/update/status',[CardController::class,'updateStatus']);
//    Route::get('/delete/{card_id}',[CardController::class,'destroy']);
//    Route::get('/deleted_cards',[CardController::class,'deletedCards']);
//});

Route::get('/test/dailyRank', [\App\Http\Controllers\RankPointController::class,'dailyRank']);
