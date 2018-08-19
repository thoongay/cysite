<?php

namespace App\Lib;

class UI
{
    public static function errors($view, $message)
    {
        return view($view)->with(['errors' => $message]);
    }
}
