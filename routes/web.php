<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SummerNoteController;


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


Route::redirect('/', '/login');

Route::view('/template/home', 'template');
Route::view('/download/', 'download');

Auth::routes();

Route::get("fcm","ColekController@fcm");


Route::get('/bdm', 'ColekController@bdm');
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

    Route::prefix('news')->group(function () {
        $cr = "NewsController";
        Route::get('create', "$cr@viewCreate");
        Route::post('store', "$cr@store");
        Route::get('{id}/edit', "$cr@viewUpdate");
        Route::post('{id}/update', "$cr@update");
        Route::get('{id}/delete', "$cr@delete");
        Route::get('manage', "$cr@viewManage");
    });

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

    Route::prefix('payment-merchant')->group(function () {
        $cr = "PaymentMerchantController";
        Route::get('tambah', "$cr@viewCreate");
        Route::post('store', "$cr@store");
        Route::get('{id}/edit', "$cr@viewUpdate");
        Route::post('{id}/update', "$cr@update");
        Route::get('{id}/delete', "$cr@delete");
        Route::get('{id}/destroy', "$cr@destroy");
        Route::get('manage', "$cr@viewManage");
    });

    Route::prefix('donation-account')->group(function () {
        $cr = "DonationAccountController";
        Route::get('tambah', "$cr@viewCreate");
        Route::post('store', "$cr@store");
        Route::get('{id}/edit', "$cr@edit");
        Route::post('{id}/update', "$cr@update");
        Route::get('{id}/delete', "$cr@delete");
        Route::get('{id}/destroy', "$cr@destroy");
        Route::get('manage', "$cr@viewManage");
    });

    Route::prefix('sodaqo')->group(function () {
        Route::get('create', [App\Http\Controllers\SodaqoCreationController::class, 'viewCreate']);
        Route::post('store', [App\Http\Controllers\SodaqoCreationController::class, 'store']);
        Route::get('{id}/edit',  [App\Http\Controllers\SodaqoCreationController::class, 'viewUpdate']);
        Route::post('{id}/update', [App\Http\Controllers\SodaqoCreationController::class, 'update']);
        Route::get('{id}/delete', [App\Http\Controllers\SodaqoCreationController::class, 'delete']);
        Route::get('manage', [App\Http\Controllers\SodaqoCreationController::class, 'viewManage']);
        Route::get('me', [App\Http\Controllers\SodaqoCreationController::class, 'viewManage']);
        Route::get("/timeline/{id}/change",[App\Http\Controllers\SodaqoTimelineController::class, 'viewUpdate']);

        Route::prefix("creation")->group(function (){

            Route::post("/story/edit",[App\Http\Controllers\SodaqoTimelineController::class, 'editStory']);
            Route::post("/update",[App\Http\Controllers\SodaqoCreationController::class, 'update']);
            Route::post("/photo/edit",[App\Http\Controllers\SodaqoCreationController::class, 'editPhoto']);


            Route::post("/timeline/store",[App\Http\Controllers\SodaqoTimelineController::class, 'store']);
            Route::post("/timeline/update",[App\Http\Controllers\SodaqoTimelineController::class, 'update']);
            Route::get("/timeline/delete",[App\Http\Controllers\SodaqoCreationController::class, 'storeStory']);

            Route::get("/expense/add",[App\Http\Controllers\SodaqoCreationController::class, 'storeStory']);
            Route::post("/expense/store",[App\Http\Controllers\SodaqoCreationController::class, 'storeStory']);
            Route::get("/expense/update",[App\Http\Controllers\SodaqoCreationController::class, 'storeStory']);
        });

        Route::prefix("{id}/transaction")->group(function (){
            Route::get("/manage",[App\Http\Controllers\TransactionController::class, 'viewManage']);
        });

    });

    Route::post("transaction/update");
    Route::post("transaction/update", [App\Http\Controllers\TransactionController::class, 'update']);
    Route::any("aaofom", [App\Http\Controllers\TransactionController::class, 'getDonationsData'])->name(
        "donations-data-ajax"
    );

    Route::any("rexs", [App\Http\Controllers\TransactionController::class, 'ddd']);

    Route::any("transaction/summary", [App\Http\Controllers\TransactionController::class, 'summaryAjax'])->name(
        "transaction_summary_ajax"
    );
    Route::any("transaction/summaryx", [App\Http\Controllers\TransactionController::class, 'summaryAjax'])->name(
        "transaction_summary_ajax"
    );
    Route::any("adaofom", [App\Http\Controllers\TransactionController::class, 'update'])->name(
        "verif_transaction_ajax"
    );

    Route::prefix('sodaqo-category')->group(function () {
        Route::get('create', [App\Http\Controllers\SodaqoCategoryController::class, 'viewCreate']);
        Route::post('store', [App\Http\Controllers\SodaqoCategoryController::class, 'store']);
        Route::get('{id}/edit',  [App\Http\Controllers\SodaqoCategoryController::class, 'viewUpdate']);
        Route::post('{id}/update', [App\Http\Controllers\SodaqoCategoryController::class, 'update']);
        Route::get('{id}/delete', [App\Http\Controllers\SodaqoCategoryController::class, 'delete']);
        Route::get('manage', [App\Http\Controllers\SodaqoCategoryController::class, 'viewManage']);
    });

});

Route::get('logout', function () {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

Route::prefix('trade')->group(function () {
    Route::get('/portfolio', [App\Http\Controllers\TradeController::class, 'getPortfolio']);
    Route::get('/portfolio/trading-balance', [App\Http\Controllers\TradeController::class, 'getTradingBalance']);
    Route::get('/check/{code}', [App\Http\Controllers\TradeController::class, 'checkEmitenOnPortfolio']);
    Route::get('/check/{code}/checkLot', [App\Http\Controllers\TradeController::class, 'checkIfLotAvailable']);
    Route::get('{code}/orderbook', [App\Http\Controllers\TradeController::class, 'getOrderBook']);

    Route::any('buy', [App\Http\Controllers\TradeController::class, 'buy']);
    Route::any('sell', [App\Http\Controllers\TradeController::class, 'sell']);
    Route::any('cancel/{emiten}/{orderId}', [App\Http\Controllers\TradeController::class, 'cancel']);
    Route::any('orders', [App\Http\Controllers\TradeController::class, 'orders']);

    Route::any('{code}/automate/beautify/bid/{nominal}', [App\Http\Controllers\TradeController::class, 'beautifyBidVolumes']);
    Route::any('{code}/automate/beautify/offer/{nominal}', [App\Http\Controllers\TradeController::class, 'beautifyOfferVolumes']);
    Route::any('withdraw/all', [App\Http\Controllers\TradeController::class, 'cancelAllOrder']);
    Route::any('bid88', [App\Http\Controllers\TradeController::class, 'bid88']);
    Route::any('offer88', [App\Http\Controllers\TradeController::class, 'offer88']);

});


Route::post('summernote-image', [SummerNoteController::class, 'store']);
Route::post('summernote-image-delete', [SummerNoteController::class, 'destroyImage']);

