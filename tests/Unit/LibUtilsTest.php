<?php

namespace Tests\Unit;

use App\Lib\Utils;
use Tests\TestCase;

class LibUtilsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCopyArray()
    {
        $expect = ['a' => 1, 'b' => 2];
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $result = Utils::CopyArray($data, ['a', 'b']);
        $this->assertEquals($expect, $result);
    }
}
