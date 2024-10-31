<div class="post mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('profiles.show', $post->user->username) }}" class="text-decoration-none">
                <strong>{{ $post->user->name }}</strong>
            </a>
            <span class="text-muted">{{ $post->created_at->diffForHumans() }}</span>
        </div>
        @auth
            @if ($post->user_id === auth()->id())
                <div>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    <h3 class="mt-2">{{ $post->title }}</h3>
    <p>{{ $post->description }}</p>
    @if ($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3" alt="Post Image">
    @endif
    <div class="mt-3">
        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-secondary">Read More</a>
    </div>
</div>
