<?php

namespace App\Http\Controllers;

//use宣言は外部にあるクラスをPostController内にインポートできる。
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Post $post)//インポートしたPostをインスタンス化して$postとして使用。
    {
        //return $post->get();//$postの中身を戻り値にする
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit(5)]);
        //getPaginateByLimit()はPost.phpで定義したメソッドです。
    }
    /**
    * 特定IDのpostを表示する
    *
    * @params Object Post // 引数の$postはid=1のPostインスタンス
    * @return Reposnse post view
    */
    public function show(Post $post)//インポートしたPostをインスタンス化して$postとして使用。
    {
        //dd($post);
        return view('posts.show')->with(['post' => $post]);
        //'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }
    
    /**
    public function create()
    {
        return view('posts/create');
    }
    */
    
    public function store(PostRequest $request, Post $post)
    {
        //dd($request->all());
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post)
    {
        return view('posts/edit')->with(['post' => $post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id );
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    

    public function create(Category $category)
    {
        return view('posts.create')->with(['categories' => $category->get()]);
    }
}
