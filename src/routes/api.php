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

//Route::middleware('sanctum:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1/')->group(function (){
    // Authentication routes
    Route::prefix('/auth')->group(function (){
        Route::post('/register', 'API\v01\Auth\AuthController@register')->name('auth.register');
        Route::post('/login', 'API\v01\Auth\AuthController@login')->name('auth.login');
        Route::get('/user', 'API\v01\Auth\AuthController@user')->name('auth.user');
        Route::post('/logout', 'API\v01\Auth\AuthController@logout')->name('auth.logout');
    });
});