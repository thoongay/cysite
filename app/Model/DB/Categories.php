<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['user', 'name', 'description'];

    public function GetAllCategories()
    {
        return $this->select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->get();
    }

    public function GetCatesArray()
    {
        $cates = $this->GetAllCategories();
        $result = [];
        for ($i = 0; $i < count($cates); $i++) {
            $result[$cates[$i]->id] = $cates[$i]->name;
        }
        return $result;
    }
}
