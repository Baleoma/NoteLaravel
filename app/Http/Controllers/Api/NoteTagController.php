<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteTagRequest;
use App\Http\Resources\Note_TagResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\TagResource;
use App\Models\NoteTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Note;


/**
 * @OA\Get(
 *     path="/api/notetag",
 *     summary="Вывод всех связей",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="note_id", type="integer", example=8),
 *                     @OA\Property(property="tag_id", type="integer", example=6),
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
 *     path="/api/notetag/{id}",
 *     summary="Вывод связи по id",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID связи",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="note_id", type="integer", example=8),
 *                     @OA\Property(property="tag_id", type="integer", example=6),
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
 *     path="/api/notetag/tags/{note_id}",
 *     summary="Вывод всех тегов заметки",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="note_id",
 *         in="path",
 *         description="ID заметки",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=6),
 *                     @OA\Property(property="name", type="string", example="ipsum"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T14:31:56.000000Z"),
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
 *     path="/api/notetag/notes/{tag_id}",
 *     summary="Вывод всех заметок связанных с этим тегом",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="tag_id",
 *         in="path",
 *         description="ID тега",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=4),
 *                     @OA\Property(property="title", type="string", example="itaque"),
 *                     @OA\Property(property="content", type="string", example="Quaerat quisquam ipsa amet maxime."),
 *                     @OA\Property(property="user_id", type="integer", example=5),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T14:31:56.000000Z"),
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
 * @OA\Post(
 *     path="/api/notetag",
 *     summary="Создание связи",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"note_id", "tag_id"},
 *             @OA\Property(property="note_id", type="integer", example=2),
 *             @OA\Property(property="tag_id", type="integer", example=6),
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="note_id", type="integer", example=2),
 *                 @OA\Property(property="tag_id", type="integer", example=6),
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
 * @OA\Delete(
 *     path="/api/notetag/{id}",
 *     summary="Удаление связи",
 *     tags={"Notetag"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID связи",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Успешное удаление (нет содержимого)"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     )
 * ),
 */

class NoteTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note_TagResource::collection(NoteTag::all()); // Работает корректно
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteTagRequest $request)
    {
        $created_notetags = NoteTag::create($request->validated()); // Работает корректно

        return new Note_TagResource($created_notetags);
    }

    public function show(int $id) { //Выводит конкретную связь
        $noteTags = NoteTag::where('id', $id)->get();
        return Note_TagResource::collection($noteTags);
    }

    public function shownotes(int $tag_id) //Выводит все теги заметки
    {
        $tag = Tag::with('note')->findOrFail($tag_id);
        return NoteResource::collection($tag->note);
    }

    public function showtags(int $note_id) //Выводит все заметки с этим тегом
    {
        $note = Note::with('tag')->findOrFail($note_id);
        return TagResource::collection($note->tag);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NoteTag $notetag)
    {
        $notetag->forceDelete();

        return response(null, 204);
    }
}
