<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/handle-timeout', "MpesaController@time_out_url")->name('handle_QueueTimeOutURL');
Route::any('/handle-b2c-result', 'MpesaController@b2c_result')->name('handle_b2c_api');
Route::any('/handle-result-lipa-online', 'MpesaController@handle_result_online')->name('handle_onlinepayment_result_api');

