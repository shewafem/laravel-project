<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Jobs\VeryLongJob;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('accept', null)->latest()->paginate(10);
        return view('comment.index', ['comments'=>$comments]);
    }

    public function accept(Comment $comment){
        $comment->accept = 1;
        $comment->save();
        return redirect()->route('comment.index');
    }
    public function reject(Comment $comment){
        $comment->accept = 0;
        $comment->save();
        return redirect()->route('comment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
        $article = Article::FindOrFail(request('id'));
        $comment = new Comment();
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->article()->associate($article); 
        $comment->user()->associate(Auth::id());
        $result = $comment->save();
        VeryLongJob::dispatch($article, $comment);
        return redirect('/article/show/'.request('id'))->with('result', $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        Gate::authorize('update-comment', $comment);
        return view('comment.edit', ['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->save();
        return redirect('/article/show/'.$comment->article_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('update-comment', $comment);
        $comment->delete();
        return redirect('/article/show/'.$comment->article_id);
    }
}