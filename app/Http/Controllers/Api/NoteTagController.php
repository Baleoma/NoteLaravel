<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteTagRequest;
use App\Http\Resources\Note_TagResource;
use App\Models\Note_Tag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Laravel\Prompts\Note;

class NoteTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note_TagResource::collection(Note_Tag::all()); // Работает корректно
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteTagRequest $request)
    {
        $created_notetags = Note_Tag::create($request->validated()); // Работает корректно

        return new Note_TagResource($created_notetags);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $note_id)
    {
        return new Note_TagResource(Note_Tag::findOrFail($note_id)); // Выдает код 500. Мб неправильно передаю значения
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //По сути обновлять ее нет смысла
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note_Tag $note_tag)
    {
        $note_tag->forceDelete(); // Такая же беда, как и везде

        return response(null, 204);
    }
}
