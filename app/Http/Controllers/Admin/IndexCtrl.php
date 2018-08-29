<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexCtrl extends Controller
{
    public function ShowTestPage()
    {
        return view('index/test');
    }
}
