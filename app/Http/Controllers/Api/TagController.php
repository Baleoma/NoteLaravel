<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;


/**
 * @OA\Get(
 *     path="/api/tag",
 *     summary="Вывод всех тегов",
 *     tags={"Tag"},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="eum"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z"),
 *                 )
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *      path="/api/tag/{id}",
 *      summary="Вывод конкретной заметки",
 *      tags={"Tag"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID тега",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=3),
 *                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z"),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not Found",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Note not found")
 *          )
 *      )
 * )
 *
 * @OA\Post(
 *      path="/api/tag",
 *      summary="Создание тега",
 *      tags={"Tag"},
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"name"},
 *              @OA\Property(property="name", type="string", example="Name Example"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Created",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=11),
 *                  @OA\Property(property="name", type="string", example="Name Example"),
 *                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-28T11:29:30.000000Z"),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Unprocessable Entity",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="The given data was invalid."),
 *              @OA\Property(property="errors", type="object")
 *          )
 *      )
 * )
 *
 * @OA\Put(
 *       path="/api/tag/{id}",
 *       summary="Обновление тега",
 *       tags={"Tag"},
 *
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           description="ID тега",
 *           required=true,
 *           @OA\Schema(type="integer")
 *       ),
 *
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               @OA\Property(property="name", type="string", example="Updated Name"),
 *           )
 *       ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="Успешное обновление",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object",
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="name", type="string", example="Updated Name"),
 *                   @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T07:59:00.000000Z"),
 *               )
 *           )
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Тег не найден",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Note not found")
 *           )
 *       ),
 *
 *       @OA\Response(
 *           response=422,
 *           description="Ошибка валидации",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="The given data was invalid."),
 *               @OA\Property(property="errors", type="object")
 *           )
 *       )
 *  )
 *
 * @OA\Delete(
 *       path="/api/tag/{id}",
 *       summary="Удаление тега",
 *       tags={"Tag"},
 *
 *      @OA\Parameter(
 *           name="id",
 *           in="path",
 *           description="ID тега",
 *           required=true,
 *           @OA\Schema(type="integer")
 *       ),
 *
 *       @OA\Response(
 *           response=204,
 *           description="Успешное удаление (нет содержимого)"
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Тег не найдена",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Note not found")
 *           )
 *       )
 *  ),
 */

class TagController extends Controller
{

    public function index()
    {
        return TagResource::collection(Tag::all()); //Работает исправно
    }


    public function store(TagRequest $request)
    {
        $created_tags = Tag::create($request->validated()); //Работает исправно

        return new TagResource($created_tags);
    }


    public function show(string $id)
    {
        return new TagResource(Tag::findOrFail($id)); // Работает исправно
    }


    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated()); // Работает исправно

        return new TagResource($tag);
    }


    public function destroy(Tag $tag)
    {
        $tag->delete(); // Не работает

        return response(null, 204);
    }
}
