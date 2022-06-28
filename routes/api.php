<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\Auth\LoginController;
use App\Http\Controllers\API\v1\Auth\RegisterController;
use App\Http\Controllers\API\v1\Auth\ForgotPasswordController;
use App\Http\Controllers\API\v1\Auth\ResetPasswordController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\PostController;
use App\Http\Controllers\API\v1\ProductController;
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
// Route::post('/login', LoginController::class);
Route::post('/login', [LoginController::class, 'index']);
Route::post('/register', [RegisterController::class, 'index']);
Route::post('/forgot_password', [ForgotPasswordController::class, 'index']);
Route::post('/reset_password', [ResetPasswordController::class, 'index']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('learnings', LearningController::class);
Route::apiResource('comments', CommentController::class)->except([
    'index', 'update', 'show'
]);
Route::apiResource('contacts', ContactController::class)->except([
     'update'
]);
Route::get('contacts/csv/download', [ContactController::class, 'exportCsv']);
Route::apiResource('subscriptions', SubscriptionController::class)->except([
    'update', 'show'
]);
Route::get('subscriptions/csv/download', [SubscriptionController::class, 'exportCsv']);
Route::apiResource('analytics', AnalyticsController::class)->only([
    'index'
]);

Route::get('/brochure/{tag}/download', [ProductController::class, 'downloadBrochure']);

Route::fallback(function (){
    abort(404, 'API resource not found');
});
