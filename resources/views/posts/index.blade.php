@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Posts</h1>

        @foreach($posts as $post)
            <div class="post">
                <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
                <p>{{ Str::limit($post->description, 100) }}</p>
                <p><strong>Author:</strong> <a href="{{ route('profile.show', $post->user->username) }}">{{ $post->user->name }}</a></p>
            </div>
            <hr>
        @endforeach

        <div class="pagination">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
