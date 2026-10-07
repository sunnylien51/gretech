<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="canonical" href="{{ $page->getUrl() }}">
<title>{{ $page->title ? $page->title . ' | ' . $page->siteName : $page->siteName }}</title>
<meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

<link rel="icon" href="{{ $page->baseUrl }}/favicon.svg?v=20261007" type="image/svg+xml">
<link rel="icon" href="{{ $page->baseUrl }}/favicon.ico?v=20261007" sizes="any">
<link rel="icon" href="{{ $page->baseUrl }}/favicon.png?v=20261007" type="image/png" sizes="32x32">
<link rel="apple-touch-icon" href="{{ $page->baseUrl }}/images/favicon.png?v=20261007" sizes="180x180">
<link rel="shortcut icon" href="{{ $page->baseUrl }}/favicon.ico?v=20261007">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500;700&family=Outfit:wght@100;300;400;500&display=swap" rel="stylesheet">

@php
    $isHome = rtrim((string) $page->getPath(), '/') === '';
    $homeAboutPreload = $isHome ? (($page->homeAbout['image'] ?? null) ?: '/images/about1.jpg') : null;
@endphp
@if ($homeAboutPreload)
<link rel="preload" as="image" href="{{ $page->baseUrl }}{{ $homeAboutPreload }}" fetchpriority="high">
@endif

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

@viteRefresh()
<link rel="stylesheet" href="{{ vite('source/_assets/css/main.css', '/static') }}">
<script defer type="module" src="{{ vite('source/_assets/js/main.js', '/static') }}"></script>

<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/@studio-freight/lenis@1.0.34/dist/lenis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
