@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    
    @if ($notifications->count() > 0)
        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item">
                    @if ($notification->type === 'App\Notifications\CommentNotification')
                        <a href="{{ route('posts.show', $notification->data['post_id']) }}">
                            New comment on your post: "{{ $notification->data['post_title'] }}"
                        </a>
                        <p class="text-muted">Commented by: {{ $notification->data['commenter_name'] }}</p>
                    @elseif ($notification->type === 'App\Notifications\FollowNotification')
                        <a href="{{ route('profiles.show', $notification->data['follower_username']) }}">
                            {{ $notification->data['follower_name'] }} followed you!
                        </a>
                    @endif
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">Mark All as Read</button>
            </form>
        </div>
    @else
        <p>No notifications available.</p>
    @endif
</div>
@endsection
