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
}
