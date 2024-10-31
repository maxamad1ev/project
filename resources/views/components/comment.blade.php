<div class="comment mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        @auth
            @if ($comment->user_id === auth()->id())
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endif
        @endauth
    </div>
    <p>{{ $comment->content }}</p>
</div>
