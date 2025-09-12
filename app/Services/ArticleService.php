<?php 

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getAllPaginated($perPage = 10)
    {
        return Article::paginate($perPage);
    }

    public function create(array $data)
    {
        return Article::create($data);
    }

    public function find($id)
    {
        return Article::find($id);
    }

    public function update($id, array $data)
    {
        $article = Article::find($id);
        if (!$article) {
            return null;
        }
        $article->update($data);
        return $article;
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return null;
        }
        $article->delete();
        return $article;
    }
}
