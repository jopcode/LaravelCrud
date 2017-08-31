@extends('layout')
@section('content')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('articles.update', $article->id) }}" method="post">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <input type="text" name="title" value="{{ $article->title }}"><br>
        <textarea name="content"  cols="30" rows="10"> {!! $article->content !!}</textarea>
        <input type="submit" value="Save!">
    </form>
@endsection