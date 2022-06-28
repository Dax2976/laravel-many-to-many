@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>{{$post->title}}</h3>
                <img src="{{assets("storage/$post->image")}}" alt="">
                <p>{{$post->description}}</p>
                <h5>Tags:</h5>
                @forelse ( $post->$tags as $tag)
                    <span class="badge" style="background-color:{{ $tag->color }} " >{{ $tag->label }}></span>
                @empty
                    <p>Notingh to Show</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection 