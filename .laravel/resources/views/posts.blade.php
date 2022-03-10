@extends('layouts')

@section('content')
    <h1>{{$title}}</h1>

    @if($posts->count())
    <div class="card mb-3 text-center">
        <img src="https://source.unsplash.com/1200x400/?{{$posts[0]->category->name}}" class="card-img-top" alt="{{$posts[0]->category->name}}">
        <div class="card-body p">
            <h5 class="card-title">{{$posts[0]->title}}</h5>
            <p>
                <small class="text-muted">
                    By
                    <a href="/author/{{$posts[0]->author->username}}" class="text-decoration-none">
                            {{$posts[0]->author->name}} 
                    </a> 
                    in 
                    <a class="text-decoration-none" href="/blog?category={{$posts[0]->category->slug}}">
                            {{$posts[0]->category->name}}
                    </a>
                    {{$posts[0]->created_at->diffForHumans()}}
                </small>
            </p>
            <p class="card-text">{{$posts[0]->excerpt}}</p>
            <a class="btn btn-primary" href="/post/{{$posts[0]->slug}}">Read More</a>
        </div>
    </div>

    <br>
    
    <div class="container">
        <div class="row">
        @foreach($posts->skip(1) as $post)
        <div class="col-md-4">
            <div class="card p" style="margin-bottom:10px">
                <div class="position-absolute px-3 py-2 text-white" 
                    style="background-color: rgba(0,0,0,.6)">
                    <a class="text-decoration-none text-white" href="/blog?category={{$post->category->slug}}">
                        {{$post->category->name}}
                    </a>
                </div>
                <img src="https://source.unsplash.com/500x400/?{{$post->category->name}}" class="card-img-top" alt="$post->category->name">
                <div class="card-body">
                    <h2>{{$post->title}}</h2>
                    <p>     
                        <small class="text-muted">
                            By. 
                            <a class="text-black" href="/author/{{$post->author->username}}" class="text-decoration-none">
                                    {{$post->author->name}} 
                            </a> 
                        </small>
                    </p> 
                    <p class="card-text">{{$post->excerpt}}</p>
                    <a class="btn btn-primary" href="/post/{{$post->slug}}">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    @else
        <p class="text-center fs-4">No Post Found</p>
    @endif
@endsection


