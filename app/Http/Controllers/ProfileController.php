<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostCollection;
use App\Http\Resources\AllPostUserLike;
use App\Http\Resources\UserCollection;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id)
    {
        try {
            $user = User::where('id', $id)->first();

            $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

            return response()->json(['user' => new UserCollection([$user]), 'postsByUser' => new AllPostCollection($posts)], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getRandomUsers()
    {
        try {
            $suggested = User::inRandomOrder()->limit(5)->get();
            $following = User::inRandomOrder()->limit(5)->get();

            return response()->json([
                'suggested' => new UserCollection($suggested),
                'following' => new UserCollection($following),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
