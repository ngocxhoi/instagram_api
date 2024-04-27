<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostCollection;
use App\Models\Post;
use App\Services\FileServices;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function show($id)
    {
        try {
            $post = Post::where('id', $id)->get();
            return response()->json(['success' => 'OK', 'post' => new AllPostCollection($post)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png',
            'text' => 'required'
        ]);
        try {
            $post = new Post;
            $post = (new FileServices)->updateFile($post, $request, 'post');

            $post->user_id = auth()->user()->id;
            $post->text = $request->input('text');
            $post->save();
            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);

            if (!empty($post->file)) {
                $currentFile = public_path() . $post->file;

                if (file_exists($currentFile)) {
                    unlink($currentFile);
                }
            }

            $post->delete();
            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
