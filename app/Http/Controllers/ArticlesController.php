<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{

    public function index()
    {

        $articles = new Article();
        $data = [
            'articles' => $articles->get()
        ];
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guest()) {
            return Redirect::route('articles.index');
        }

        return view('new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guest()) {
            return Redirect::route('articles.index');
        }
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'title' => 'required|max:90',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $article = new Article([
            'title' => Input::get('title'),
            'content' => Input::get('content'),
            'user' => Auth::user()->name,
        ]);

        $article->save();
        return Redirect::route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $comments = $article->comments()->get();
        $data = [
            'article' => $article,
            'comments' => $comments,
        ];
        return view('show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guest()) {
            return Redirect::route('articles.index');
        }
        $article = Article::find($id);
        return view('edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if($article->user != Auth::user()->name) {
            return Redirect::route('articles.index');
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'title' => 'required|max:90',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $article->title = Input::get('title');
        $article->content = Input::get('content');
        $article->save();
        return Redirect::route('articles.show', $article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guest()) {
            return Redirect::route('articles.index');
        }

        $article = Article::find($id);

        if($article->user != Auth::user()->name) {
            return Redirect::route('articles.index');
        }

        $article->delete();
        return Redirect::route('articles.index');

    }

    public function newComment(Request $request) {
        if(Auth::guest()) {
            return Redirect::route('articles.index');
        }
        $comment = new Comment(['content' => Input::get('content'), 'user' => Auth::user()->name]);
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255'
        ]);
        if($validator->fails()) {
           return back()->withErrors($validator)->withInput();
        }
        $article = Article::find(Input::get('articleId'));
        $article->Comments()->save($comment);
        return back();

    }
}
