<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotesController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\Note_TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'tags' => TagsController::class,
    'notes' => NotesController::class,
    'note_tag'=>Note_TagController::class,
]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

