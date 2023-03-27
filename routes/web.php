<?php

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

Route::get('users/me', ['as' => 'usersMe','uses'=>'App\Http\Controllers\MeController@getMe']);

//User == Retailer usando o principio de solid pra deixar o codigo organizado e padronizado
Route::post('/auth/{provider}',['as' => 'authentication','uses'=>'App\Http\Controllers\AuthController@authentication']);

Route::post('/transactions', ['as' => 'postTransaction','uses'=>'App\Http\Controllers\Transactions\TransactionsController@postTransaction']);