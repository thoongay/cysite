<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = ['url', 'article', 'mark', 'author'];

    public function Disconnect($id)
    {
        $this->where(['article' => $id])->update(['article' => 0]);
    }

    public function Connect($mark, $id)
    {
        $this->where(['mark' => $mark])->update(['article' => $id]);
    }
    public function MarkUploadedImage($url, $mark, $author)
    {
        $record = [
            'url' => $url,
            'mark' => $mark,
            'author' => $author,
        ];

        $this->create($record);
    }
}
