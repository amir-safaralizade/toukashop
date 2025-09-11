@php use Modules\Seo\Enums\SeoMetaKey; @endphp

@if ($value = $get(SeoMetaKey::META_TITLE))
    <title>{{ $value }}</title>
@endif

@if ($value = $get(SeoMetaKey::META_DESCRIPTION))
    <meta name="description" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::META_KEYWORDS))
    <meta name="keywords" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::CANONICAL))
    <link rel="canonical" href="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::ROBOTS))
    <meta name="robots" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::OG_TITLE))
    <meta property="og:title" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::OG_DESCRIPTION))
    <meta property="og:description" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::OG_IMAGE))
    <meta property="og:image" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::TWITTER_TITLE))
    <meta name="twitter:title" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::TWITTER_DESCRIPTION))
    <meta name="twitter:description" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::TWITTER_IMAGE))
    <meta name="twitter:image" content="{{ $value }}">
@endif

@if ($value = $get(SeoMetaKey::CUSTOM_SCHEMA))
    {!! '<script type="application/ld+json">' . $value . '</script>' !!}
@endif
