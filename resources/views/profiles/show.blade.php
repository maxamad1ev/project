@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $user->name }}'s Profile</h1>

            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

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

            <h2>{{ $user->username }}'s Posts</h2>
            @if ($user->posts->count() > 0)
                @foreach ($user->posts as $post)
                    <div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->description }}</p>
                    </div>
                @endforeach
            @else
                <p>No posts yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
