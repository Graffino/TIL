@extends('layouts.app')

@section('title', 'Graffino')

@section('content')
<div class="container">
<svg class="icon js-slide-top slide-button hidden">
    <use xlink:href="#sprite-mouse-up"/>
</svg>
  <div class="feed__wrapper">
    @each('posts.partials.post', $posts, 'post', 'posts.partials.empty')
    @if( method_exists( $posts,'links' ) )
        {{ $posts->links() }}
    @endif
  </div>
</div>
@endsection
