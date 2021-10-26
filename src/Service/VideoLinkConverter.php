<?php

namespace App\Service;

class VideoLinkConverter
{
    public static function convert(string $url)
    {
        $pattern = "#^https://www\.youtube\.com/watch\?v=(?P<id>[a-zA-Z0-9-_]+)$#i";
        $iframePattern = "#https://www\.youtube\.com/embed/(?P<id>[a-zA-Z0-9-_]+)#im";
        $shortCodePattern = "#^https://youtu\.be/(?P<id>[a-zA-Z0-9-_]+)#i";

        if (preg_match($pattern, $url, $matches)) {
            $url = "https://www.youtube.com/embed/" . $matches['id'];
            return $url;
        }
        if (preg_match($iframePattern, $url, $matches)) {
            $url = "https://www.youtube.com/embed/" . $matches['id'];
            return $url;
        }
        if (preg_match($shortCodePattern, $url, $matches)) {
            $url = "https://www.youtube.com/embed/" . $matches['id'];
            return $url;
        }
        return $url;
    }
}
