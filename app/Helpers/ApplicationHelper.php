<?php

namespace App\Helpers;

class ApplicationHelper
{
    public static function canonicalUrl($slug)
    {
        $appUrl = config('app.domain');

        $url = $appUrl . '/' . $slug;
        $url = rtrim($url, '/');

        return $url;
    }
}
