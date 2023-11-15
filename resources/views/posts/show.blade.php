@extends('layouts.app')

@section('content')
    id: {{$post->id}} <br>
    title: {{$post->title}} <br>
    content : {{$post->content}} <br>
    created_at : {{$post->created_at}} <br>
    <a href="{{route('posts.index')}}">목록</a>
    <a href="{{route('posts.edit', $post->id)}}">수정</a>
@endsection

@section('footer')

@endsection
