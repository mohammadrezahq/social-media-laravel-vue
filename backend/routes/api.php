<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// Auth Routes
Route::post('/u/login', [AuthController::class, 'login']);
Route::post('/u/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    // User Routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/u/get', 'show');
        Route::post('/u/search', 'search');
        Route::post('/u/update', 'update');
        Route::post('/u/avatar', 'avatar');
        Route::post('/u/password', 'password');
        Route::post('/u/logout', 'logout');
        Route::delete('/u/delete', 'delete');
    });

    // Post Routes
    Route::controller(PostController::class)->group(function () {
        Route::post('/p/show', 'show');
        Route::get('/p/explore', 'explorePosts');
        Route::post('/p/updateExplore', 'updateExplore');
        Route::get('/p/feed', 'getFeed');
        Route::post('/p/add', 'store');
        Route::post('/p/update', 'update');
        Route::post('/p/delete', 'delete');
    });

    // Follow Routes
    Route::post('/f/do', [FollowController::class, 'doFollow']);
    Route::post('/f/check', [FollowController::class, 'haveFollow']);

    // Comment Routes
    Route::post('/c/get', [CommentController::class, 'get']);
    Route::post('/c/do', [CommentController::class, 'store']);
    //  Route::delete('/c/delete', [CommentController::class, 'delete']);

    // Like Routes
    Route::post('/l', [LikeController::class, 'doLike']);
});
