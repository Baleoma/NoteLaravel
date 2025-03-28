<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Http\Resources\TagsResource;
use App\Models\Notes;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TagsResource::collection(Tags::all()); //Работает исправно
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagsRequest $request)
    {
        $created_tags = Tags::create($request->validated()); //Работает исправно

        return new TagsResource($created_tags);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TagsResource(Tags::findOrFail($id)); // Работает исправно
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagsRequest $request, Tags $tags)
    {
        $tags->update($request->validated()); // Возвращает json со всеми null и не меняет ничего в базе

        return new TagsResource($tags);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tags $tags)
    {
        $tags->forceDelete(); // 204 код возвращает, но в базе запись не удаляется, даже с forceDelete

        return response(null, 204);
    }
}
