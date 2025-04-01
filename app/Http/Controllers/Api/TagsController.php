<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Http\Resources\TagsResource;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    public function index()
    {
        return TagsResource::collection(Tag::all()); //Работает исправно
    }


    public function store(TagsRequest $request)
    {
        $created_tags = Tag::create($request->validated()); //Работает исправно

        return new TagsResource($created_tags);
    }


    public function show(string $id)
    {
        return new TagsResource(Tag::findOrFail($id)); // Работает исправно
    }


    public function update(TagsRequest $request, Tag $tag)
    {
        $tag->update($request->validated()); // Работает исправно

        return new TagsResource($tag);
    }


    public function destroy(Tag $tag)
    {
        $tag->delete(); // Работает исправно

        return response(null, 204);
    }
}
