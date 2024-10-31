@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    <form action="{{ route('profile.update', Auth::user()->username) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', Auth::user()->username) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
    </form>
</div>
@endsection
