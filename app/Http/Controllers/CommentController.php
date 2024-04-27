<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'text' => 'required',
        ]);

        try {
            $comment = new Comment;

            $comment->post_id = $request->post_id;
            $comment->user_id = $request->user_id;
            $comment->text = $request->text;

            $comment->save();
            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function updatePostComment($id)
    {
        try {
            $comments = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->get();
            return response()->json(['comments' => new CommentCollection($comments)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            $comment->delete();
            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
