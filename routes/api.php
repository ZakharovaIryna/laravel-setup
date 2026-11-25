<?php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExternalApiController;

Route::get('/external-tasks', [ExternalApiController::class, 'index']);
Route::get('/external-tasks/{id}', [ExternalApiController::class, 'show']);
Route::post('/external-tasks', [ExternalApiController::class, 'store']);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('tasks.comments', CommentController::class)->shallow();