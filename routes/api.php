<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\NoteTagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'tag' => TagController::class,
        'note' => NoteController::class,
        'notetag' => NoteTagController::class,
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/notetag/tags/{note_id}', [NoteTagController::class, 'showtags'])->middleware('auth:sanctum');
Route::get('/notetag/notes/{tag_id}', [NoteTagController::class, 'shownotes'])->middleware('auth:sanctum');

