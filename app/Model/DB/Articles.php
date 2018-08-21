<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = ['title', 'content', 'keyword', 'text', 'author', 'category'];

    public function GetAllArticles()
    {
        return $this->orderBy('id', 'desc')->paginate(10);
    }
}
