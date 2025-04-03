<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


/**
 * @OA\Get(
 *     path="/api/note",
 *     summary="Вывод всех заметок",
 *     tags={"Note"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="eum"),
 *                     @OA\Property(property="content", type="string", example="Iste rerum dolorem aut aliquid vel. Vero suscipit sit"),
 *                     @OA\Property(property="user_id", type="integer", example=6),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/note/{id}",
 *     summary="Вывод конкретной заметки",
 *     tags={"Note"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID заметки",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=3),
 *                 @OA\Property(property="title", type="string", example="necessitatibus"),
 *                 @OA\Property(property="content", type="string", example="Tenetur repellat sapiente dignissimos dolorem culpa qui. Et nihil voluptatum quidem voluptatum repellat cum. Dolorem delectus doloribus expedita."),
 *                 @OA\Property(property="user_id", type="integer", example=10),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Note not found")
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/note",
 *     summary="Создание заметки",
 *     tags={"Note"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "content", "user_id"},
 *             @OA\Property(property="title", type="string", example="Title Example"),
 *             @OA\Property(property="content", type="string", example="Content Example"),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=11),
 *                 @OA\Property(property="title", type="string", example="Title Example"),
 *                 @OA\Property(property="content", type="string", example="Content Example"),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-28T11:29:30.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/note/{id}",
 *     summary="Обновление заметки",
 *     tags={"Note"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID заметки",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Title"),
 *             @OA\Property(property="content", type="string", example="Updated content"),
 *             @OA\Property(property="user_id", type="integer", example=6)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешное обновление",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Updated Title"),
 *                 @OA\Property(property="content", type="string", example="Updated content"),
 *                 @OA\Property(property="user_id", type="integer", example=6),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Заметка не найдена",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Note not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/note/{id}",
 *     summary="Удаление заметки",
 *     tags={"Note"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID заметки",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Успешное удаление (нет содержимого)"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Заметка не найдена",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Note not found")
 *         )
 *     )
 * )
 */


class NoteController extends Controller
{
    /**
     * Вывод всех заметок
     */
    public function index()
    {
        return NoteResource::collection(Note::all());
    }

    /**
     * Создание заметки
     */
    public function store(NoteRequest $request)
    {
        $note = Note::create($request->validated());
        return new NoteResource($note);
    }

    /**
     * Вывод конкретной заметки
     */
    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    /**
     * Обновление заметки
     */
    public function update(NoteRequest $request, Note $note)
    {
        Gate::authorize('update', $note);
        $note->update($request->validated());
        return new NoteResource($note);
    }

    /**
     * Удаление заметки
     */
    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);
        $note->delete();
        return response()->noContent();

    }

}
