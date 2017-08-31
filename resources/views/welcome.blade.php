@extends('layout')
@section('content')
    @foreach($articles as $article)
        <h1>{{$article->title}}</h1>
        <p>{{substr($article->content, 0, 20)}}</p>
        <small>By: {{$article->user}}</small>
        <a href="{{ route('articles.show', $article->id) }}"> Read more</a>
        <hr>
        <br>
    @endforeach
@endsection()