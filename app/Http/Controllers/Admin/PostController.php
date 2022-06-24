<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Tag;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function show(Post $post){
        return view('admin.posts.show',compact('post'));
    }

    public function create(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories','tags'));
    }

    public function store(Request $request){
        $data = $request->all();
        $post = new Post();
        $post->fill($data);
        $post->slug = Str::slug($post->title,'-');
        $post->save();

        if ( array_key_exists( 'tags', $data ) )  $post->tags()->attach($data['tags']);

        return rederict()->route('admin.posts.index');
    }

    public function edit(Post $post){
        return view('admin.posts.edit',compact('post'));
    }

    public function update(Request $request, Post $post){
        $data = $request->all();
        $post['slug'] = Str::slug($request->title,'-');
        $post->update($data);

        return redirect()->route('admin.posts.index',$post);
    }

    public function destroy(Post $post){
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
