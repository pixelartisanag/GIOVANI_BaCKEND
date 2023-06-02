<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideoController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PurchaseController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    // Your protected routes
});

Route::middleware(['auth:sanctum', 'role:Admin|Moderator'])->group(function () {
    // Your protected routes
});

// Routes for all authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UsersController::class);

    Route::get('stories', [StoryController::class, 'index']);
    Route::get('stories/{story}', [StoryController::class, 'show']);

    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/{video}', [VideoController::class, 'show']);

    Route::get('galleries', [GalleryController::class, 'index']);
    Route::get('galleries/{gallery}', [GalleryController::class, 'show']);
    Route::put('galleries/{gallery}', [GalleryController::class, 'update']);
    Route::delete('galleries/{gallery}', [GalleryController::class, 'destroy']);

    Route::post('galleries', [GalleryController::class, 'store']);

    Route::get('featured', [ApiController::class, 'featuredPosts']);
    Route::get('home', [ApiController::class, 'homePosts']);

    Route::apiResource('groups', GroupController::class);
    Route::apiResource('messages', MessageController::class);
    Route::get('/groups/{group}/messages', [MessageController::class, 'index']);

    Route::post('/broadcasting/auth', [BroadcastController::class, 'authenticate']);
    Route::post('/typing',  [BroadcastController::class, 'setTyping']);

    Route::post('/webrtc/signal', [BroadcastController::class, 'signal']);
    Route::post('/webrtc/disconnect', [BroadcastController::class, 'disconnect']);

    Route::post('/purchases', [PurchaseController::class, 'store']);
    Route::get('/purchases', [PurchaseController::class, 'index']);
});

// Routes for Admins and Moderators only
Route::middleware(['auth:sanctum', 'role:Admin|Moderator'])->group(function () {
    Route::post('stories', [StoryController::class, 'store']);
    Route::put('stories/{story}', [StoryController::class, 'update']);
    Route::delete('stories/{story}', [StoryController::class, 'destroy']);
});

Route::apiResource('plans', PlanController::class);
Route::apiResource('purchases', PurchaseController::class);

Route::post('/contact', [ApiController::class, 'sendContactEmail']);



