<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::paginate(6);
        return view('posts.index', compact('posts'));
    }

    // public function show(Post $post)
    // {
    //     return view('posts.show', compact('post'));
    // }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function create()
    {
        if (Auth::user()->posts->count() >= 3) {
            return to_route('posts.index')->with('error', 'You have reached the maximum number of posts allowed per user.');
        }
        return view('posts.create');
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $image_path = $post->image;
        if ($request->hasFile('image')) {
            if ($image_path) {
                Storage::disk('posts_images')->delete($image_path);
            }

            $image = $request->file('image');
            $image_path = $image->store("", 'posts_images');
        }

        $request_data = request()->all();
        $request_data['image'] = $image_path;

        $post->update($request_data);
        return to_route("posts.show", $post->slug);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return to_route('posts.index')->with('success', 'Post has been deleted successfully');
    }

    public function hardDestroy(Request $request)
    {
        $post = Post::withTrashed()->find($request->id);
        $this->authorize('forceDelete', $post);

        if ($post->image) {
            Storage::disk('posts_images')->delete($post->image);
        }

        $post->forceDelete();
        return to_route('posts.trash')->with('success', 'Post has been deleted successfully');
    }

    public function restore(Request $request)
    {
        if (Auth::user()->posts->count() >= 3) {
            return to_route('posts.trash')->with('error', 'You have reached the maximum number of posts allowed per user.');
        }
        $post = Post::withTrashed()->find($request->id);
        $this->authorize('restore', $post);

        $post->restore();
        return to_route('posts.trash')->with('success', "Post $post->title has been restored successfully");
    }

    public function restoreAll()
    {
        if (Auth::user()->posts->count() >= 3) {
            return to_route('posts.trash')->with('error', 'You have reached the maximum number of posts allowed per user.');
        }
        Post::onlyTrashed()->where('user_id', Auth::user()->id)->restore();
        return to_route('posts.trash')->with('success', 'All deleted posts have been restored successfully.');
    }

    public function showDeletedPosts()
    {
        $posts = Post::onlyTrashed()->where('user_id', Auth::user()->id)->paginate(6);

        return view('posts.trash', compact('posts'));
    }

    function store(StorePostRequest $request, Post $post)
    {
        $image_path = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store("", 'posts_images');
        }

        $request_data = request()->all();
        $request_data['image'] = $image_path;
        $request_data['user_id'] = Auth::user()->id;

        $post = Post::create($request_data);
        return to_route("posts.show", $post->slug);
    }
}
