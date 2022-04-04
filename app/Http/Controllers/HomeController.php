<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

//        $toggler = Post::with('likes')->where('user_id', '=', auth()->id())->exists();

        $posts = Post::select('posts.*')
            ->with('user')
//            ->join('following', 'following.followed_id', '=', 'posts.user_id')
            ->with('likes')
            ->with('dislikes')
//            ->with('comments')
            ->latest()->get()->all();

        return Inertia::render('Home/Index', [
            'posts' => $posts,
            'likeToggle' => Post::with('likes')->where('user_id', '=', auth()->id())->exists(),

        ]);
    }
}

