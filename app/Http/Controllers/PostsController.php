<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use function GuzzleHttp\Promise\all;

class PostsController extends Controller
{

    public function index(Post $post)
    {
//        $post=Post::all();

//        dd($comments);

        return Inertia::render('Posts/Index', [
            'post' => Post::with('user')->where("id", "=", $post->id)->get()->first(),
            'comments' => Comment::with('post')->where("post_id","=", $post->id)->with('user')->get(),
//            'posts' => Post::with('user')->where("user_id", "=", $user->id)->get(),

        ]);

    }

    public function create()
    {
        return Inertia::render('Posts/Create');

    }


    public function store()
    {
        $attributes = request()->validate([
            'body' => 'required|max:255',
            'image' => 'nullable|image',
            'user_id' => ['nullable', Rule::exists('users', 'id')->where(function ($query) {
                $query->where('user_id', Auth::user()->id);
            })],


        ]);

        Post::create([
            'user_id' => auth()->id(),
            'body' => $attributes['body'],
//            'image'=> $imagePath,
        ]);

        return Redirect::route('home');
    }


    public function edit(Post $post)
    {
        return Inertia::render('Home/Edit', [
            'post' => [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'body' => $post->body,
                'image' => $post->image,
//                'avatar' => $user->avatar ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
//                'cover' => $user->cover ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
//                'description' => $user->description,
            ]
        ]);
    }

    public function update(Post $post)
    {
        $attributes = request()->validate([
            'body' => ['string', 'max:255'],
        ]);
        $post->update($attributes);

        return Redirect::route('dashboard');

    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post = delete();
        return Redirect::route('dashboard');
    }
}
