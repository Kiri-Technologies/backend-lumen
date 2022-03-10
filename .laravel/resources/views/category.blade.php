@extends('layouts')

@section('content')
    <h1>Post Category : {{$category}}</h1>
    <article class="mb-5">
        @foreach($posts as $post)
        <h2>
            <a href="/post/{{$post->slug}}">{{$post->title}}</a>
        </h2>
        {{$post->excerpt}}
        @endforeach
    </article>
@endsection

