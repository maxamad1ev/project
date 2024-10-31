<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->with('user')->get();
        return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images');
        }

        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete($post->image);
            }
            $data['image'] = $request->file('image')->store('images');
        }

        $post->update($data);
        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        if ($post->image) {
            Storage::delete($post->image);
        }
        
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
?>