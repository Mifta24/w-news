<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        // JSON Response
        // return response()->json(['data' => $posts], 200);

        // API Resource
        return PostResource::collection($posts);
    }
    public function show(Post $post)
    {
        return new PostResource($post->loadMissing('author:id,username'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);
        $request['author_id'] = auth()->user()->id;
        $post = Post::create($request->all());

        return new PostResource($post->loadMissing('author:id,username'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return new PostResource($post->loadMissing('author:id,username'));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
