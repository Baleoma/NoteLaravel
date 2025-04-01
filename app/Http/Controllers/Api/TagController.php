<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;

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
        $tag->delete(); // Работает исправно

        return response(null, 204);
    }
}
