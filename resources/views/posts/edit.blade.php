@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    <form method="post" action="/posts/{{$post->id}}">
        @csrf
        <input type="hidden" name="_method" value="PUT" />
{{--        <input type="hidden" name="user_id" value="{{$post->id}}" />--}}
        <input type="text" name="title" placeholder="Enter title" value="{{$post->title}}" />
        <textarea name="content" id="content" cols="30" rows="10">{{$post->content}}</textarea>
        <input type="submit" value="수정" />
    </form>
    <a href="{{route('posts.show', $post->id)}}">보기</a>
    <hr>
    <form method="post" action="/posts/{{$post->id}}">
        @csrf
        <input type="hidden" name="_method" value="DELETE" />
        <input type="submit" value="삭제" />
    </form>
@endsection

@section('footer')

@endsection
