@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">All Users</h1>
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" alt="{{ $user->name }}" class="rounded-circle mb-3" width="100" height="100">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ '@' . $user->username }}</p>
                        <a href="{{ route('profiles.show', $user->username) }}" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection