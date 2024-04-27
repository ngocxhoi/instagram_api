<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeCollection;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function updatePostLike($id)
    {
        try {
            $likes = Like::where('post_id', $id)->get();
            if (empty($likes)) return response()->json(['likes' => []], 200);
            return response()->json(['likes' => new LikeCollection($likes)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['post_id' => 'required']);

        try {
            $like = new Like;

            $like->user_id = auth()->user()->id;
            $like->post_id = $request->post_id;
            $like->save();
            return response()->json(['success' => 'OK'], 200);
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
            $like = Like::findOrFail($id);
            $like->delete();
            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
