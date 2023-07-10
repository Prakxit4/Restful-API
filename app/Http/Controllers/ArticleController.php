<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        Paginator::currentPageResolver(function () use ($request) {
            return $request->query('page', 1); 
        });

        $articles = Article::paginate($perPage);

        return response()->json($articles);
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $article = Article::create($validatedData);

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
    
        $article->update($validatedData);
    
        return response()->json($article, 200);
    }
    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
