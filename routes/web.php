<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenralSettingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');


Route::prefix('profile')->middleware('auth')->group(function (){
    Route::get('/',[ProfileController::class, 'edit'])->name('profile');
    Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('setting')->middleware('auth')->group(function (){

    Route::prefix('order')->middleware('auth')->group(function (){
        Route::get('/',[OrderController::class, 'index'])->name('setting.order');
//        Route::post('/avatar/add', [AvatarController::class, 'store'])->name('avatar.add');
        Route::post('/order/update', [OrderController::class, 'update'])->name('order.update');
        Route::post('/order/delete', [OrderController::class, 'destroy'])->name('order.delete');
    });

    Route::prefix('category')->middleware('auth')->group(function (){
        Route::get('/',[CategoryController::class, 'index'])->name('setting.category');
        Route::post('/category/add', [CategoryController::class, 'store'])->name('category.add');
        Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    Route::prefix('size')->middleware('auth')->group(function (){
        Route::get('/',[SizeController::class, 'index'])->name('setting.size');
        Route::post('/size/add', [SizeController::class, 'store'])->name('size.add');
        Route::post('/size/update', [SizeController::class, 'store'])->name('size.update');
        Route::post('/size/delete', [SizeController::class, 'destroy'])->name('size.delete');
    });

    Route::prefix('product')->middleware('auth')->group(function (){
        Route::get('/',[ProductController::class, 'index'])->name('setting.product');
        Route::post('/product/add', [ProductController::class, 'store'])->name('product.add');
        Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/delete', [ProductController::class, 'destroy'])->name('product.delete');
    });

    Route::prefix('stock')->middleware('auth')->group(function (){
        Route::get('/',[StockController::class, 'index'])->name('setting.stock');
        Route::post('/stock/add', [StockController::class, 'store'])->name('stock.add');
        Route::post('/stock/update', [StockController::class, 'update'])->name('stock.update');
        Route::post('/stock/delete', [StockController::class, 'destroy'])->name('stock.delete');
    });

//    Route::prefix('general')->middleware('auth')->group(function (){
//        Route::get('/',[GenralSettingController::class, 'index'])->name('setting.general');
//        Route::post('/general/store', [GenralSettingController::class, 'store'])->name('general.store');
////        Route::post('/media/update', [MediaController::class, 'update'])->name('media.update');
////        Route::post('/media/delete', [MediaController::class, 'destroy'])->name('media.delete');
//    });

});

//Route::prefix('takeTest/front')->group(function () {
//    Route::get('/start', function () {
//        return view('test.start');
//    })->name('start');
//    Route::post('/', [UserTestController::class, 'startWeb'])->name('takeTest.start');
//    Route::post('/save_questions', [UserTestController::class, 'saveQuestionsWeb'])->name('takeTest.saveQuestions');
//});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
