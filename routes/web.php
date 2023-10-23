<?php

use Illuminate\Support\Facades\Redirect;
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
    return view('welcome');
});

Route::view('/template/home', 'template');
Route::view('/profile/home', 'profile/home');
Route::view('/profile/home2', 'profile/home2');
Route::view('/profile/home3', 'profile/home3');

Auth::routes();


Route::redirect('/', '/login');


Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'admin']);
    Route::get('/staff', [App\Http\Controllers\HomeController::class, 'index']);

    Route::prefix('outbond')->group(function () {
        Route::get('create', 'OutbondController@viewCreate');
        Route::post('store', 'OutbondController@store');
        Route::get('{id}/cancel', 'OutbondController@cancelKeluar');
        Route::post('/update', 'OutbondController@update');
        Route::get('{id}/delete', 'OutbondController@destroy');
        Route::get('manage', 'OutbondController@viewManage');
    });


    Route::post('/user/store', [App\Http\Controllers\StaffController::class, 'store']);
    Route::post('/user/update', [App\Http\Controllers\StaffController::class, 'update']);
    Route::get('/user/{id}/delete', [App\Http\Controllers\StaffController::class, 'destroy']);



    Route::get('/material/create', [App\Http\Controllers\MaterialController::class, 'viewCreate']);
    Route::get('/material/{id}/delete', [App\Http\Controllers\MaterialController::class, 'destroy']);

    Route::post('/material/store', 'MaterialController@store');
    Route::get('/material/{id}/edit', 'MaterialController@edit');
    Route::post('/material/update', 'MaterialController@update');
    Route::get('/material/{id}/delete', 'MaterialController@destroy');
    Route::get('/material/manage', 'MaterialController@viewManage');


    Route::prefix('customer')->group(function(){
        Route::get('create', [App\Http\Controllers\CustomerController::class, 'viewCreate']);
        Route::get('{id}/delete', [App\Http\Controllers\CustomerController::class, 'destroy']);
        Route::post('store', 'SupplierController@store');
        Route::get('{id}/edit', 'SupplierController@viewEdit');
        Route::post('update', 'SupplierController@update');
        Route::get('{id}/delete', 'SupplierController@destroy');
        Route::get('/customer/manage', 'SupplierController@viewManage');

    });

    Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'viewCreate']);
    Route::get('/supplier/{id}/delete', [App\Http\Controllers\SupplierController::class, 'destroy']);
    Route::post('/supplier/store', 'SupplierController@store');
    Route::get('/supplier/{id}/edit', 'SupplierController@viewEdit');
    Route::post('/supplier/update', 'SupplierController@update');
    Route::get('/supplier/{id}/delete', 'SupplierController@destroy');
    Route::get('/supplier/manage', 'SupplierController@viewManage');


    Route::get('/menu/create', [App\Http\Controllers\MenuController::class, 'viewCreate']);
    Route::get('/supplier/{id}/delete', [App\Http\Controllers\SupplierController::class, 'destroy']);
    Route::post('/menu/store', 'MenuController@store');
    Route::get('/menu/{id}/edit', 'MenuController@viewEdit');
    Route::post('/menu/update', 'MenuController@update');
    Route::get('/menu/{id}/delete', 'MenuController@destroy');
    Route::get('/menu/manage', 'MenuController@viewManage');

    Route::post('/ingredients/store', [App\Http\Controllers\MenuMaterialController::class, 'store']);
    Route::get('/ingredients/{id}/delete', [App\Http\Controllers\MenuMaterialController::class, 'destroy']);


    Route::prefix('inbound')->group(function () {
        Route::get('/create', [App\Http\Controllers\InboundController::class, 'viewCreate']);
        Route::get('/{id}/cancel', 'InboundController@cancel');
        Route::post('/store', 'InboundController@store');
        Route::get('/{id}/edit', 'InboundController@viewEdit');
        Route::post('/update', 'InboundController@update');
        Route::get('/{id}/delete', 'InboundController@destroy');
        Route::get('/report', 'InboundController@viewManage');
        Route::get('/manage', 'InboundController@viewManage');
        Route::get('/input-daily', 'InboundController@viewInputDaily');
        Route::get('/daily-input', 'InboundController@viewInputDaily');
        Route::post('/daily-input/store', 'InboundController@storeDaily');
    });


    Route::get('/admin/user/create', [App\Http\Controllers\StaffController::class, 'viewAdminCreate']);
    Route::get('/admin/user/manage', [App\Http\Controllers\StaffController::class, 'viewAdminManage']);
    Route::get('/admin/user/{id}/edit', [App\Http\Controllers\StaffController::class, 'viewAdminEdit']);
});





Route::get('logout', function () {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');
