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

Route::get('/landing', function () {
    return view('index');
})->name('landing');


Route::view('/ryy', '168_template');


//Route::redirect('/', '/login');

Route::view('/template/home', 'template');
Route::view('/download/', 'download');

Auth::routes();


Route::get('/registerz', 'CustomAuthController@register');
Route::post('/proceedLogin', 'Auth\LoginController@proceedLogin');

Route::get('/artisan/dropDonasi', 'ArtisanController@dropDonasi');
Route::get('/artisan/drop', 'ArtisanController@drop');

Route::get('/drop/{schemeName}', 'ColekController@drop');

Route::post('/register', 'StaffController@store');
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'admin']);
    Route::get('/user', [App\Http\Controllers\HomeController::class, 'user']);
    Route::get('/staff', [App\Http\Controllers\HomeController::class, 'index']);

    Route::get('/admin/user/manage', [App\Http\Controllers\StaffController::class, 'viewAdminManage']);
    Route::get('/admin/user/create', [App\Http\Controllers\StaffController::class, 'viewAdminCreate']);

    Route::prefix('user')->group(function () {
        Route::get('create', [App\Http\Controllers\StaffController::class, 'viewAdminCreate']);
        Route::get('{id}/edit', [App\Http\Controllers\StaffController::class, 'viewAdminEdit']);
        Route::post('{id}/change-photo', [App\Http\Controllers\StaffController::class, 'updateProfilePhoto']);
        Route::get('{id}/detail', [App\Http\Controllers\StaffController::class, 'viewDetail']);
        Route::post('change-password', [App\Http\Controllers\StaffController::class, 'updatePassword']);
        Route::post('store', [App\Http\Controllers\StaffController::class, 'store']);
        Route::post('update', [App\Http\Controllers\StaffController::class, 'update']);
        Route::get('{id}/delete', [App\Http\Controllers\StaffController::class, 'destroy']);
    });


});

Route::get('logout', function () {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

Route::post('summernote-image', [SummerNoteController::class, 'store']);
Route::post('summernote-image-delete', [SummerNoteController::class, 'destroyImage']);
