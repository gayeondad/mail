<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $posts = Post::all();
        $posts = Post::latest()->get();
        // $posts = Post::orderBy('id', 'desc')->get();
        // return $posts;
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        // Request 선언 시 사용
        // $this->validate($request, [
        //     'title' => 'required|max:20',
        //     'content' => 'required'
        // ]);
        // Request 대신 생성한 CreatePostRequest 사용인 경우 validate 는 CreatePostRequest 의 rule 적용
        
        // $file = $request->file('ftu');
        // // var_dump($file);
        // echo $file->getClientOriginalName();
        // echo '<br />';
        // echo $file->getClientSize();    // window라서 그런가.. size 항목이 없어서 에러 발생 (유닉스에선 될려나??)

        $input = $request->all();
        if ($file = $request->file('ftu')) {
            $name = $file->getClientOriginalName();
            $file->move('images', $name);
            $input['path'] = $name;
        }
        // if (Post::create($request->all())) return redirect('/posts');
        if (Post::create($input)) return redirect('/posts');
        return 'fail';
        // return $request->all();
        // return $request->get('title');
        // return $request->title;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();
//        Post::whereId($id)->delete();
        return redirect('/posts');
    }
}
