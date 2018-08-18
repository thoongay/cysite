<?php

namespace App\Model\Enum;

// usage:  $level = LogLevel::Info;

abstract class LogLevel
{
    const Info = 0;
    const Warn = 1;
    const Error = 2;
}
