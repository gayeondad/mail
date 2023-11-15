@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form method="post" action="/posts">
        @csrf
        <input type="hidden" name="user_id" value="1" />
        <input type="text" name="title" placeholder="Enter title" />
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <input type="submit" value="저장" />
    </form>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection

@section('footer')

@endsection
