@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->description }}</p>
        <p><strong>Author:</strong> <a href="{{ route('profile.show', $post->user->username) }}">{{ $post->user->name }}</a></p>
        <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="img-fluid">

        <hr>

        @auth
            @if($post->user_id == auth()->id())
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endif
        @endauth

        <h3>Comments</h3>
        @foreach($post->comments as $comment)
            <p>{{ $comment->content }}</p>
            <p><strong>{{ $comment->user->name }}</strong> - {{ $comment->created_at->diffForHumans() }}</p>

            @auth
                @if($comment->user_id == auth()->id())
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Comment</button>
                    </form>
                @endif
            @endauth

            <hr>
        @endforeach

        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" placeholder="Leave a comment"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        @endauth
    </div>
@endsection
