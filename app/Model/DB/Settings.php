<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['name', 'options', 'type', 'content', 'description'];

    #region public method
    public function GetSettingByFieldID($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function GetAllSetting()
    {
        return $this->select(['id', 'name', 'type', 'option', 'description'])->get();
    }
    #endregion
}
