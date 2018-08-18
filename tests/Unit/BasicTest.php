<?php

namespace Tests\Unit;

use Tests\TestCase;

class BasicTest extends TestCase
{
    public function testDirectoryWriteAble()
    {
        $dir = public_path() . '\uploads';
        $this->assertDirectoryExists($dir);
        $this->assertDirectoryIsReadable($dir);
        $this->assertDirectoryIsWritable($dir);
    }
}
