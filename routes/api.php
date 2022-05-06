<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\API\v1\Auth\LoginController;
use App\Http\controllers\API\v1\Auth\RegisterController;
use App\Http\controllers\API\v1\Auth\ForgotPasswordController;
use App\Http\controllers\API\v1\Auth\ResetPasswordController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\PostController;
use App\Http\Controllers\API\v1\CommentController;
use App\Http\Controllers\API\v1\ContactController;
use App\Http\Controllers\API\v1\SubscriptionController;
use App\Http\Controllers\API\v1\LearningController;
use App\Http\Controllers\API\v1\AnalyticsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/* 
    Authentication Route
*/
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/forgot_password', ForgotPasswordController::class);
Route::post('/reset_password', ResetPasswordController::class);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('learnings', LearningController::class);
Route::apiResource('comments', CommentController::class)->except([
    'index', 'update', 'show'
]);
Route::apiResource('contacts', ContactController::class)->except([
     'update'
]);
Route::apiResource('subscriptions', SubscriptionController::class)->except([
    'update', 'show'
]);
Route::apiResource('analytics', AnalyticsController::class)->only([
    'index'
]);
Route::fallback(function (){
    abort(404, 'API resource not found');
});
