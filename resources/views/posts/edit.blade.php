@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Post Image</label>
                <input type="file" name="image" class="form-control">
                <small>Current Image:</small>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="img-fluid mb-2">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
@endsection
