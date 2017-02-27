<?php

use PHPUnit\Framework\TestCase;

class TestClass extends TestCase
{
    public function testCanBeCreatedFromPath()
    {
        $this->assertInstanceOf(
            Philandi\ImgSpector\Image::class,
            Philandi\ImgSpector\Image::createFromPath(dirname(__FILE__) . '/test.png')
        );
    }

    public function testCannotBeCreatedFromNonexistentPath()
    {
        $this->expectException(Exception::class);

        Philandi\ImgSpector\Image::createFromPath(dirname(__FILE__) . '/nonexistent.png');
    }
}
