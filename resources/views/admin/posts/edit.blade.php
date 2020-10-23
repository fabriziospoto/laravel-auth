@extends('layouts.app')
@section('content')
        {{-- gestione errori --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


    <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <img src="{{ asset('storage/'. $post->img) }}" alt="{{ $post->slug }}" class="col-md-4">
        <div class="form-group">
            <label for="title">Immagine</label>
            <input type="file" name="img" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" name="body" rows="3">{{ $post->body }}</textarea>
        </div>

        <div class="form-group">
            @foreach($tags as $tag)
                <label for="tag">{{ $tag->name }}</label>
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ ($post->tags->contains($tag->id) ? 'checked' : '') }}>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
