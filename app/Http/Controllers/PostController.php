<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // dd($posts);
        return view('posts.index', ['posts' => $posts]);
    }

    function create()
    {
        return view('posts.create');
    }

    // Request = ファザード
    function store(Request $request)
    {
        // $requestに入っている値を、new Postでデータベースに保存する
        $post = new Post;
        $post -> title = $request -> title;
        $post -> body = $request -> body;
        // Auth::id = データを送ったユーザー
        $post -> user_id = Auth::id();

        $post -> save();

        return redirect() -> route('posts.index');
    }

    function show($id)
    {
        // postsテーブルから１つのidのデータを取ってくる
        $post = Post::find($id);
        return view('posts.show', ['post'=>$post]);
    }

    function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post -> title = $request -> title;
        $post -> body = $request -> body;
        $post -> save();

        return view('posts.show', compact('post'));
    }

    function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
