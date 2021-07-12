<?php

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


Route::prefix('v1/')->group(function () {
    // Authentication routes
    include __DIR__. '/v1/auth_routes.php';
    // Channel routes
    include __DIR__. '/v1/channel_routes.php';
    // Thread and answers routes
    include __DIR__. '/v1/thread_routes.php';
    // User routes
    include __DIR__. '/v1/user_routes.php';
});