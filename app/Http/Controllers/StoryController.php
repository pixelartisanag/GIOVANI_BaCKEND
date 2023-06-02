<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = Story::paginate(10); // Change the number to the desired stories per page
        return StoryResource::collection($stories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'role' => 'required',
            'media_gallery' => 'required',
            'published' => 'required',
            'uri' => 'required|unique:stories',
        ]);

        $story = Story::create($request->all());

        return response()->json($story, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $story = Story::findOrFail($id);
        return response()->json($story);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'role' => 'required',
            'media_gallery' => 'required',
            'published' => 'required',
            'uri' => "required|unique:stories,uri,$id",
        ]);

        $story = Story::findOrFail($id);
        $story->update($request->all());

        return response()->json($story);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return response()->json(null, 204);
    }
}
