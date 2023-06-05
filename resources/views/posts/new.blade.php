@extends('layouts.app')

@section('title', 'New Post')

@section('content')
  <div class="container">
    <h1 class="h-align-center">Create a new post</h1>
    <form class="form" action="{{ route('posts.create') }}" method="post">
      {{ csrf_field() }}
      <div class="form__field">
        <label class="form__label">Title</label>
        @if ($errors->has('name'))
          <span class="text -color-white">
            <strong>{{ $errors->first('title') }}</strong>
          </span>
        @endif
        <input data-pristine-required type="text" class="form__input" name="post_title" value={{ old('title') }}>
      </div>
      <div class="form__field">
        <label class="form__label">Content</label>
        @if ($errors->has('body'))
          <span class="text -color-white">
            <strong>{{ $errors->first('body') }}</strong>
          </span>
        @endif
        <textarea data-pristine-required id="editor" class="form__textarea" rows="10" name="body">{{ old('body') }}</textarea>
      </div>
      <div class="form__field">
        <label class="form__label">Channel</label>
        <select class="form__select" name="channel_id">
          @foreach ($channels as $channel)
            <option value="{{ $channel['id']}}">{{ $channel['name']}}</option>
          @endforeach
        </select>
      </div>
      @include('posts.meta')
      <div class="form__field h-center">
        <button id="submit-button" class="button -color-white" type="submit">Post</button>
        <a class="link h-margin-left-10" href="{{ route('posts') }}">Cancel</a>
      </div>
    </form>
    <label class="form__label">Html Preview</label>
    <div id="html-preview"></div>
    <div id="editor-choice" data-choice="{{ Auth::user()->editor }}"></div>
  </div>
@endsection

<style>
    .pristine-error {
        margin-top: -15px;
        margin-bottom: 10px;
        color: red;
    }
</style>
