@extends('layouts.app')

@section('content')
    <ul>
        @foreach($posts as $post)
            <li><img height="80" src="{{$post->path}}" alt="" /><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></li>
        @endforeach
    </ul>
@endsection

@section('footer')

@endsection
