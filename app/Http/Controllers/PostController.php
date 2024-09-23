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
}
