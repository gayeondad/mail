@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form method="post" action="/posts" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="1" />
        <div class="form-group">
            <input type="text" name="title" placeholder="Enter title" />
        </div>
        <div class="form-group">
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group">
            <input type="file" name="ftu" />
        </div>
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
