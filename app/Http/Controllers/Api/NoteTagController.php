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

    public function shownotes(int $tag_id)
    {
        $tag = Tag::with('note')->findOrFail($tag_id); // Используйте полное пространство имен
        return NoteResource::collection($tag->note);
    }

    public function showtags(int $note_id)
    {
        $note = Note::with('tag')->findOrFail($note_id); // Используйте полное пространство имен
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
