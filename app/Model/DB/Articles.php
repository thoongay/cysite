<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = ['title', 'content', 'keyword', 'text', 'author', 'category'];

    public function GetRecentArticles($cateNames, $cateArray)
    {
        $cache = [];
        foreach ($cateNames as $cateName) {
            $cache[$cateName] = [];
            $cateID = array_search($cateName, $cateArray);
            if ($cateID) {
                $articles = $this->select(['id', 'title', 'created_at'])
                    ->where(['category' => $cateID])
                    ->latest()
                    ->take(config('app.admin.articleCacheSize'))
                    ->get();

                foreach ($articles as $article) {
                    $cache[$cateName][] = [
                        'id' => $article->id,
                        'title' => $article->title,
                        'create' => $article->created_at->timestamp,
                    ];
                }
            }
        }
        return $cache;
    }

    public function GetAllArticles()
    {
        return $this->orderBy('id', 'desc')->paginate(10);
    }
}
