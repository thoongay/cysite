<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = ['title', 'content', 'keyword', 'text', 'author', 'category'];

    public function GetRecentArticles($cateNames, $cateArray)
    {
        $cache = [];

        // cateName to cateID
        $cateIDs = [];
        foreach ($cateNames as $cateName) {
            $id = array_search($cateName, $cateArray);
            if ($id) {
                $cateIDs[] = $id;
            }
        }

        $articles = $this->select(['id', 'title', 'created_at'])
            ->whereIn('category', $cateIDs)
            ->latest()
            ->take(config('app.admin.articleCacheSize'))
            ->get();

        foreach ($articles as $article) {
            $cache[] = [
                'id' => $article->id,
                'title' => $article->title,
                'create' => $article->created_at->timestamp,
            ];
        }

        return $cache;
    }

    public function GetArticleTitlesByCateName($cateName, $cateArray, $pageSize = 10)
    {
        $id = array_search($cateName, $cateArray);
        if (!$id) {
            return null;
        }

        return $this->select(['id', 'title', 'created_at'])
            ->where('category', $id)
            ->orderBy('id', 'desc')
            ->paginate($pageSize);
    }

    public function GetAllArticles($pageSize = 10)
    {
        return $this->orderBy('id', 'desc')->paginate($pageSize);
    }
}
