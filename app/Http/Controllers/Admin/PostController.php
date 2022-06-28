<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendNewMail;


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
        $user = Auth::user();
        $post = new Post();

        if(array_key_exists('image', $data)){
            $image_url = Storage::put('post_images', $data['image']);
            $data['image'] = $image_url;
        }

        $post->fill($data);
        $post->slug = Str::slug($post->title,'-');
        $post->save();

        if ( array_key_exists( 'tags', $data ) )  $post->tags()->attach($data['tags']);
        return rederict()->route('admin.posts.index');

        $mail = New SendNewMail();
        Mail::to($user->email)->send($mail);
    }

    public function edit(Post $post){
        return view('admin.posts.edit',compact('post'));
    }

    public function update(Request $request, Post $post){

        $data = $request->all();
        $post['slug'] = Str::slug($request->title,'-');

        if(array_key_exists('image', $data)){
            if($post->image) Storage::delete($post->image);

            $image_url = Storage::put('post_images', $data['image']);
            $data['image'] = $image_url;
        }

       
        $post->update($data);

        return redirect()->route('admin.posts.index',$post);
    }

    public function destroy(Post $post){
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
