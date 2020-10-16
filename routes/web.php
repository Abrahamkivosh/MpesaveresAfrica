<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('c2b', 'MpesaController@c2bCall')->name("c2bcall");
Route::post('b2c', 'MpesaController@b2cCall')->name("b2vcall");
Route::post('lipanampesa', 'MpesaController@lipanampesa')->name("lipanampesa");
Route::post('reverse', 'MpesaController@reverse')->name("reverse");
