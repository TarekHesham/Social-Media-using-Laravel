<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Post;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creators = Creator::paginate(6);
        return view('creators.index', compact('creators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::all();
        return view('posts.create', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(Creator $creator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creator $creator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Creator $creator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creator $creator)
    {
        //
    }
}
