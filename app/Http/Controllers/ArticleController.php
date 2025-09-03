<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::paginate(10);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        Article::create($request->validated());
        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article not found.');
        }

        return view('articles.edit', compact('article'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request,  $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article not found.');
        }

        $article->update($request->validated());
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article not found.');
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
