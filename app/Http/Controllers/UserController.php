<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostCollection;
use App\Http\Resources\UserCollection;
use App\Models\Post;
use App\Models\User;
use App\Services\FileServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = User::where('id', auth()->user()->id)->get();
            return response()->json(['success' => 'OK', 'user' => new UserCollection($user)], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            if (!empty($request->email)) {
                $user->email = $request->email;
            }
            $user->save();
            return response()->json(['success' => 'OK', 'user' => new UserCollection([$user])], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateUserImage(Request $request)
    {
        $request->validate(['file' => 'required|mimes:jpg,jpeg,png']);
        try {
            $user = User::find(auth()->user()->id);
            $user = (new FileServices)->updateFile(auth()->user(), $request, 'user');
            $user->save();
            return response()->json(['success' => 'OK', 'file' => $user->file], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
