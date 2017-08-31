@extends('layout')
@section('content')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('articles.store') }}" method="post">
        {{csrf_field()}}
        <input type="text" name="title" placeholder="Title"><br>
        <textarea name="content" placeholder="Content" cols="30" rows="10"></textarea>
        <input type="submit" value="Send!">
    </form>
@endsection