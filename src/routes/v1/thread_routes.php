<?php

use \App\Http\Controllers\API\v1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;


Route::resource('threads', 'API\v1\Thread\ThreadController');


//Route::prefix('/thread')->group(function () {
//
//    Route::get('/all', [ThreadController::class, 'index'])->name('thread.all');
//
//    Route::middleware(['can:thread_management', 'auth:sanctum'])->group(function () {
//
//        Route::post('/create', [ThreadController::class, 'createNewThread'])->name('thread.create');
//        Route::put('/update', [ThreadController::class, 'updateThread'])->name('thread.update');
//        Route::delete('/delete', [ThreadController::class, 'deleteThread'])->name('thread.delete');
//    });
//});
