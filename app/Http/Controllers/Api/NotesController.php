<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesRequest;
use App\Http\Resources\NotesResource;
use App\Models\Note;
use Illuminate\Http\Request;



class NotesController extends Controller
{
    public function index()
    {
        return NotesResource::collection(Note::all());
    }

    public function store(NotesRequest $request)
    {
        $created_note = Note::create($request->validated());
        return new NotesResource($created_note);
    }

    public function show(string $id)
    {
        return new NotesResource(Note::findOrFail($id));
    }

    public function update(Request $request, Note $note)
    {
        $note->update($request->validated());
        return new NotesResource($note);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response(null, 204);
    }
}
