@extends('layout')
@section('content')
    @if(!Auth::guest() && $article->user == Auth::user()->name)
        <a href="{{ route('articles.edit', $article->id) }}" style="float: left;">Edit</a>
        <form action="{{route('articles.destroy', $article->id)}}" method="post">
            {{csrf_field()}}
            {{ method_field('DELETE') }}
            <input type="submit" value="delete">
        </form>
    @endif
<h1>{{$article->title}}</h1>
<p>{{$article->content}}</p>
<small>By: {{$article->user}}</small>
<hr>
<h3>Comments on this post: </h3>
<br>
@foreach($comments as $comment)

    <p>{{ $comment->content }}</p>
    <small>By: {{ $comment->user }}</small>
    <br>
    <br>
@endforeach

<hr>
<h3>Place a Comment</h3>
    @guest
        <b>Please Log-in for place a comment</b>
    @else

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/newcomment" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="articleId" value="{{$article->id}}">
        <textarea name="content" id="" cols="30" rows="10" placeholder="Content of comment"></textarea>
        <br>
        <input type="submit" value="Comment!">
    </form>
    @endguest
@endsection