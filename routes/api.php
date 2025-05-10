<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//user api
Route::group(['prefix'=>'users'] , function(){
    Route::get('all' , [UserController::class , 'index']);
    Route::post('/' , [UserController::class , 'store']);
    Route::get('{id}/show' , [UserController::class , 'show']);
    Route::put('{id}/update' , [UserController::class , 'update']);
    Route::delete('{id}/delete' , [UserController::class , 'destroy']);
});

//posts api
Route::group(['prefix'=>'posts'] , function(){
    Route::get('all' , [PostController::class , 'index']);
        Route::post('/' , [PostController::class , 'store']);
        Route::get('{id}/show' , [PostController::class , 'show']);
        Route::put('{id}/update' , [PostController::class , 'update']);
        Route::delete('{id}/delete' , [PostController::class , 'destroy']);
});
