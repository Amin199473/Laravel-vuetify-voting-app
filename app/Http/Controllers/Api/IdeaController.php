<?php

namespace App\Http\Controllers\Api;

use App\Models\Idea;
use App\Models\Vote;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\IdeaResource;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Comment;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idea = IdeaResource::collection(Idea::latest()->paginate(5));
        return $idea;
    }

    public function vote(Idea $idea)
    {
        $idea->toggleVote(auth()->user());
        return response()->json(['message' => 'you succefully toggled votes'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        $user_id = auth()->user()->id;
        Idea::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'status_id' => 1,
            'user_id' => $user_id,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Your Idea created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        $idea = new IdeaResource($idea);
        return $idea;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //Authorization
        if (auth()->guest() || auth()->user()->cannot('update', $idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $category_id = Category::where('name', $request->category)->first()->id;
        $idea->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $category_id,
            'description' => $request->description,
        ]);
        return response()->json(['message' => 'Your Idea Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        if (auth()->guest() || auth()->user()->cannot('delete', $idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }
        Vote::where('idea_id',$idea->id)->delete();
        Comment::where('idea_id',$idea->id)->delete();
        $idea->delete();
        return response()->json(['message' => 'Your Idea deleted Successfully'], 200);
    }
}
