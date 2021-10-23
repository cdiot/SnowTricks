<?php

namespace App\Tests;

use App\Service\VideoLinkConverter;
use PHPUnit\Framework\TestCase;

class VideoLinkConverterTest extends TestCase
{
    public function testIsEquals()
    {
        $this->assertEquals('https://www.youtube.com/embed/n6ayRk', VideoLinkConverter::convert('https://www.youtube.com/watch?v=n6ayRk'));
        $this->assertEquals('https://www.youtube.com/embed/tipzIn6ayRk', VideoLinkConverter::convert('https://youtu.be/tipzIn6ayRk'));
        $this->assertEquals('https://www.youtube.com/embed/tipzIn6ayRk', VideoLinkConverter::convert('https://www.youtube.com/embed/tipzIn6ayRk'));
    }

    public function testIsEmpty()
    {
        $this->assertEmpty(VideoLinkConverter::convert(''));
    }
}
