<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\NoteTagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Публичные маршруты (без авторизации)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Защищенные маршруты (с авторизацией)
Route::middleware('auth:sanctum')->group(function () {
    // Информация о текущем пользователе
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Ресурсы API
    Route::apiResources([
        'tag' => TagController::class,
        'note' => NoteController::class,
        'notetag' => NoteTagController::class,
    ]);

    // Дополнительные маршруты NoteTag
    Route::get('/notetag/tags/{note_id}', [NoteTagController::class, 'showtags']);
    Route::get('/notetag/notes/{tag_id}', [NoteTagController::class, 'shownotes']);

    // Выход из системы
    Route::get('/logout', [AuthController::class, 'logout']);
});

