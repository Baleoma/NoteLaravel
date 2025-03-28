<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesRequest;
use App\Http\Resources\NotesResource;
use App\Models\Notes;
use Illuminate\Http\Request;



class NotesController extends Controller
{
    public function index()
    {
        return NotesResource::collection(Notes::all());
    }

    public function store(NotesRequest $request)
    {
        $created_note = Notes::create($request->validated());
        return new NotesResource($created_note);
    }

    public function show(string $id)
    {
        return new NotesResource(Notes::findOrFail($id));
    }

    public function update(Request $request, Notes $notes)
    {
        $notes->update($request->validated());
        return new NotesResource($notes);
    }

    public function destroy(Notes $notes)
    {
        $notes->delete();
        return response(null, 204);
    }
}
