<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostCollection;
use App\Http\Resources\UserCollection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::orderBy('created_at', 'desc')->get();
            $users = User::all()->except(Auth::id());
            return response()->json(['success' => 'OK', 'posts' => new AllPostCollection($posts), 'allUsers' => new UserCollection($users)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
