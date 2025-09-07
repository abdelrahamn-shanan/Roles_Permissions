<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\ArticleService;


class ArticleController extends Controller implements HasMiddleware
{

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    /**
     * Apply permissions middleware to controller methods
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view article', only: ['index']),
            new Middleware('permission:add article', only: ['create','store']),
            new Middleware('permission:edit article', only: ['edit','update']),
            new Middleware('permission:delete article', only: ['destroy']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->articleService->getAllPaginated(10);
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
        $this->articleService->create($request->validated());
        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {

        $article = $this->articleService->find($id);
;
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
        $article = $this->articleService->find($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article not found.');
        }
        $this->articleService->update($id, $request->validated());
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = $this->articleService->find($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article not found.');
        }

        $this->articleService->delete($id);
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
