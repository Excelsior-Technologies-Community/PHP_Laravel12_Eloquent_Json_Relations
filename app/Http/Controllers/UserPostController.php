<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class UserPostController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    public function create($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::all();

        return view('users.add-post', compact('user', 'posts'));
    }

    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $postIds = $user->post_ids ?? [];

        if (!in_array((int)$request->post_id, $postIds)) {
            $postIds[] = (int)$request->post_id;
        }

        $user->update([
            'post_ids' => array_values($postIds)
        ]);

        return redirect('/users')->with('success', 'Post added!');
    }

    public function remove($userId, $postId)
    {
        $user = User::findOrFail($userId);

        $postIds = collect($user->post_ids ?? [])
            ->filter(fn($id) => $id != $postId)
            ->values()
            ->toArray();

        $user->update([
            'post_ids' => $postIds
        ]);

        return back()->with('success', 'Post removed!');
    }
}