<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::paginate(6);
        return response()->json([
            'posts' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post_validator = Validator::make($request->all(), [
            "title" => "required|min:3|unique:posts,title",
            "description" => "required|min:10",
            "image" => "image|mimes:jpeg,jpg,png|max:2048"
        ]);

        if ($post_validator->fails()) {
            return response()->json([
                "message" => "Errors with your request",
                "errors" => $post_validator->errors()
            ], 422);
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store("", 'posts_images');
        }

        $request_data = request()->all();
        $request_data['image'] = $image_path;
        $request_data['user_id'] = Auth::user()->id;

        $post = Post::create($request_data);
        return response()->json([
            'message' => 'Post has been created successfully',
            'post' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'post' => new PostResource($post)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post_validator = Validator::make($request->all(), [
            "title" => "min:3",
            "description" => "min:10",
            "image" => "image|mimes:jpeg,jpg,png|max:2048"
        ]);

        if ($post_validator->fails()) {
            return response()->json([
                "message" => "Errors with your request",
                "errors" => $post_validator->errors()
            ], 422);
        }


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
        return response()->json([
            'message' => 'Post has been updated successfully',
            'post' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post has been deleted successfully'], 204);
    }
}
