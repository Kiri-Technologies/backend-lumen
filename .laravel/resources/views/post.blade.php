@extends('layouts')

@section('content')
        <div class="container">
                <div class="row  mb-5">
                        <div class="col-md-8">
                                <h2>{{$post->title}}</h2> 
                                <p>     
                                By. 
                                <a href="/author/{{$post->author->username}}" 
                                class="text-decoration-none">
                                        {{$post->author->name}} 
                                </a> 
                                in 
                                <a class="text-decoration-none" href="/blog?category={{$post->category->slug}}">
                                        {{$post->category->name}}
                                </a>
                                </p>
                                <img src="https://source.unsplash.com/1200x500/?{{$post->category->name}}" class="img-fluid" alt="{{$post->category->name}}">

                                <article class="my-3 fs-5">
                                        {!!$post->body!!}
                                </article>
                                <br>
                                <a href="/blog"> Kembali </a>  
                        </div>
                </div>
        </div>
@endsection
