<?php

use \App\Http\Controllers\API\v1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;


Route::resource('threads', 'API\v1\Thread\ThreadController');


Route::prefix('/threads')->group(function () {

    Route::resource('answers', 'API\v1\Thread\AnswerController');

});
