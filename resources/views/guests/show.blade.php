@extends('layouts.app')
@section('content')

    <div class="col mb-4">
        <div class="card col-md-4">
            <img src="{{Storage::url($post->img)}}" class="card-img-top w-100" alt="{{$post->title}}">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text">{{$post->body}}</p>
            </div>
        </div>
    </div>

@endsection
