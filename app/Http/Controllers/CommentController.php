<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Idea;

class CommentController extends Controller
{
    public function getComments($slug)
    {$idea = Idea::where('slug', $slug)->first();
        $comments = CommentResource::collection($idea->comments);
        return $comments;
    }

    public function store(StoreCommentRequest $request, $slug)
    {
        $user_id = auth()->user()->id;
        $idea_id = Idea::where('slug', $slug)->first()->id;

        Comment::create(
            [
                'user_id' => $user_id,
                'idea_id' => $idea_id,
                'body' => $request->body,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Your Commnet add it Successfully!',
        ], 200);
    }

    public function show(Comment $comment)
    {
        //
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $user_id = auth()->user()->id;
        $idea_id = Idea::where('slug', $request->slug)->first()->id;
        $comment->update([
            'user_id' => $user_id,
            'idea_id' => $idea_id,
            'body' => $request->comment,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Your Commnet Updated it Successfully!',
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Your Commnet deleted it Successfully!',
        ], 200);
    }
}
