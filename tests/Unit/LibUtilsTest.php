<?php

namespace Tests\Unit;

use App\Lib\Utils;
use Tests\TestCase;

class LibUtilsTest extends TestCase
{
    public function testHtml2Text()
    {
        $htmls = ['<a>hello,</a><b>world!</b>'];
        $expects = ['hello,WORLD!'];

        for ($i = 0; $i < count($htmls); $i++) {
            $this->assertEquals($expects[$i], Utils::Html2Text($htmls[$i]));
        }
    }

    public function testCopyArray()
    {
        $expect = ['a' => 1, 'b' => 2];
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $result = Utils::CopyArray($data, ['a', 'b']);
        $this->assertEquals($expect, $result);
    }

    public function testCopyArrayIfKeyExist()
    {
        $expect = ['a' => 1, 'c' => 3];
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $result = Utils::CopyArrayIfKeyExist($data, ['a', 'c', 'd']);
        $this->assertEquals($expect, $result);
    }
}
