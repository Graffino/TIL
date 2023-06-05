@section('meta_keywords', $post->seo ?? '')
@section('description', $post->description ?? '')
@section('canonical_url', $post->canonical_url ?? '')
@section('social_image_url', $post->social_image_url ?? '')

<div class="form">
    <label class="form__label">Keywords (minimum 3 keywords)</label>
    <div class="form__label">
        <input type="text" class="form__input" name="meta_keywords" value="{{ old('$post->seo', $post->seo ?? '') }}" placeholder="ex: javascript, code, web development, code, vuejs">
        <label class="form__label">Description (Appears in Google Search under the title, minumum 60 chars, maximum 160 chars)</label>
        <textarea id="description" class="form__textarea" name="description">{{ old('$post->description', $post->description ?? '') }}</textarea>
        <label class="form__label">Canonical URL (Leave empty unless instructed otherwise)</label>
        <input type="text" class="form__input" name="canonical_url" value="{{ old('$post->canonical_url', $post->canonical_url ?? '')}}">
        <label class="form__label">Social media image URL (Leave empty unless instructed otherwise)</label>
        <input type="text" class="form__input" name="social_image_url" value="{{ old('$post->social_image_url', $post->social_image_url ?? '')}}">
    </div>
</div>
