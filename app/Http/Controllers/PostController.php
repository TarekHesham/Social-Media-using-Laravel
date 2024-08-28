<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Creator;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Users here should be from database
        return view('posts.edit', compact('post'));
    }

    public function create()
    {
        $creators = Creator::all();
        return view('posts.create', compact('creators'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

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
        return to_route("posts.show", $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('posts.index')->with('success', 'Post has been deleted successfully');
    }

    public function hardDestroy(Request $request)
    {
        $post = Post::withTrashed()->find($request->id);
        if ($post->image) {
            Storage::disk('posts_images')->delete($post->image);
        }

        $post->forceDelete();
        return to_route('posts.trash')->with('success', 'Post has been deleted successfully');
    }

    public function restore(Request $request)
    {
        $post = Post::withTrashed()->find($request->id);
        $post->restore();
        return to_route('posts.trash')->with('success', "Post $post->title has been restored successfully");
    }

    public function restoreAll()
    {
        Post::onlyTrashed()->restore();
        return to_route('posts.trash')->with('success', 'All deleted posts have been restored successfully.');
    }

    public function showDeletedPosts()
    {
        $posts = Post::onlyTrashed()->paginate(6);
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

        $post = Post::create($request_data);
        return to_route("posts.show", $post);
    }
}
