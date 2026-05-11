<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\MaterialController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);

// Route untuk handle data setelah login sukses di Google
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:2,1');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:2,1');

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/materials', [MaterialController::class, 'index']);
Route::get('/materials/{id}', [MaterialController::class, 'show']);
Route::get('/works', [WorkController::class, 'index']);
Route::get('/members', [MemberController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-articles', [ArticleController::class, 'myArticles']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::post('/articles/upload-image', [ArticleController::class, 'uploadImage']);
    Route::post('/articles/{id}', [ArticleController::class, 'update']);
    Route::put('/articles/{id}/submit', [ArticleController::class, 'submit']);
    Route::post('/articles/{id}/moderate', [CommentController::class, 'moderate']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
    Route::patch('/articles/{id}/status', [ArticleController::class, 'updateStatus']);

    Route::middleware('is_admin')->group(function () {
        Route::patch('/articles/{id}/approve', [ArticleController::class, 'approve']);
        Route::put('/users/{userId}', [AdminController::class, 'updateRole']);
        Route::delete('/users/{userId}', [AdminController::class, 'destroy']);
        Route::get('/users', [AdminController::class, 'index']);
        Route::put('/admin/update-role/{user}', [AdminController::class, 'updateRole']);
        Route::put('/admin/update-role/{user}', [AdminController::class, 'updateRole']);
        Route::put('/articles/{id}/takedown', [ArticleController::class, 'takedown']);
        Route::apiResource('members', MemberController::class);
        Route::apiResource('works', WorkController::class);
        Route::post('/materials', [MaterialController::class, 'store']);
        Route::put('/materials/{id}', [MaterialController::class, 'update']);
        Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);
    });

    Route::middleware('is_editor')->group(function () {
    });
});
