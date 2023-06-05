<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Accept-CH" content="DPR, Width, Viewport-Width">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="domain-name" content="{{ config('app.domain') }} ">
    <meta name="keywords" content="@hasSection('meta_keywords')@yield('meta_keywords')@else{{'graffino til, til, learning, today i learned , things i learned, learn, programming'}}@endif">
    <meta name="description" content="@hasSection('description')@yield('description')@else @yield('title'){{' • TIL - Learn new things everyday! Check out our latest tips and tricks we’re discovering in our everyday work.'}}@endif">
    <link rel="canonical" href="@hasSection('canonical_url')@yield('canonical_url')@else{{ViewHelper::getCurrentUrl()}}@endif">
    <meta property="og:title" content="@yield('title'){{' • Today I Learned'}}">
    <meta property="og:url" content="{{ViewHelper::getCurrentUrl()}}" >
    <meta property="og:type" content="website" >
    <meta property="og:description" content="@hasSection('description')@yield('description')@else @yield('title'){{' • TIL - Learn new things everyday! Check out our latest tips and tricks we’re discovering in our everyday work.'}}@endif">
    <meta property="og:image" content="@hasSection('social_image_url')@yield('social_image_url')@else{{asset('/images/social.jpg')}}@endif">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@graffinoweb">
    <meta name="twitter:creator" content="@graffinoweb">
    <meta name="twitter:title" content="@yield('title'){{' • Today I Learned'}}">
    <meta name="twitter:description" content="@hasSection('description')@yield('description')@else @yield('title'){{' • TIL - Learn new things everyday! Check out our latest tips and tricks we’re discovering in our everyday work.'}}@endif">
    <meta name="twitter:image" content="@hasSection('social_image_url')@yield('social_image_url')@else{{asset('/images/social.jpg')}}@endif">

    <title>@yield('title'){{' • Today I Learned'}}</title>
  </head>
  <body>
    @yield('content')
  </body>
</html>
