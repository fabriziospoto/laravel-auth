@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            @foreach ($posts as $post)
                <div class="col mb-4">
                    <div class="card">
                        <img src="{{Storage::url($post->img)}}" class="card-img-top" alt="{{$post->title}}">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{Str::substr($post->body,0,100)}}...</p>
                            <a href="{{ route('guest.posts.show',$post->slug) }}" class="btn btn-primary">Dettagli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
