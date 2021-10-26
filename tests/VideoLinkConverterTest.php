<?php

namespace App\Tests;

use App\Service\VideoLinkConverter;
use PHPUnit\Framework\TestCase;

class VideoLinkConverterTest extends TestCase
{


    /**
     * @dataProvider convertProvider
     */
    public function testConvert($expected, $string)
    {
        $this->assertEquals($expected, VideoLinkConverter::convert($string));
    }



    public function convertProvider()
    {

        yield 'navigatorLink' => ['https://www.youtube.com/embed/n6ayRk', 'https://www.youtube.com/watch?v=n6ayRk'];
        yield 'embed' => ['https://www.youtube.com/embed/tipzIn6ayRk', 'https://www.youtube.com/embed/tipzIn6ayRk'];
        yield 'tiny' => ['https://www.youtube.com/embed/tipzIn6ayRk', 'https://youtu.be/tipzIn6ayRk'];
        yield 'iframe' => ['https://www.youtube.com/embed/tipzIn6ayRk', '<iframe width="560" height="315" src="https://www.youtube.com/embed/tipzIn6ayRk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'];
    }

    public function testIsEmpty()
    {
        $this->assertEmpty(VideoLinkConverter::convert(''));
    }
}
