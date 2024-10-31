@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header">
        <h2>{{ $user->name }}'s Profile</h2>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Followers:</strong> {{ $followersCount }}</p>
        <p><strong>Following:</strong> {{ $followingCount }}</p>

        @auth
            @if (Auth::id() !== $user->id)
                @if ($isFollowing)
                    <form action="{{ route('profile.unfollow', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Unfollow</button>
                    </form>
                @else
                    <form action="{{ route('profile.follow', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Follow</button>
                    </form>
                @endif
            @endif
        @endauth
    </div>

    <div class="profile-posts mt-5">
        <h3>Posts by {{ $user->username }}</h3>
        @if ($user->posts->count() > 0)
            @foreach ($user->posts as $post)
                <div class="post-item mt-3">
                    <h4>{{ $post->title }}</h4>
                    <p>{{ $post->description }}</p>
                </div>
            @endforeach
        @else
            <p>No posts available.</p>
        @endif
    </div>
</div>
@endsection
