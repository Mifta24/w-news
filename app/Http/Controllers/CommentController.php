<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {

        $request->validate([
            'comments_content' => 'required',
        ]);
        $request['user_id'] = auth()->user()->id;
        $post->comments()->create($request->all());

        return new PostResource($post->loadMissing('author:id,username', 'comments'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comments_content' => 'required',
        ]);

        $comment->update($request->all());
        return new CommentResource($comment->loadMissing('post:id,title,news_content,author_id', 'user:id,username'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['data', $comment]);
    }
}
