<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('comments:id,post_id,user_id,comments_content', 'author:id,username')->get();

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
        // Validasi input
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Cek apakah ada file yang diupload
        if ($request->hasFile('image')) {
            // Simpan file gambar ke dalam folder 'images' di storage publik
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar yang diupload, gunakan gambar default
            $validated['image'] = 'images/default.png';
        }

        // Set author_id dengan ID pengguna yang sedang login
        $validated['author_id'] = auth()->user()->id;

        // Simpan data post ke dalam database
        $post = Post::create($validated);

        // Kembalikan response dengan PostResource dan memuat relasi author
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
