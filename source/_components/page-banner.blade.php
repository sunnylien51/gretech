{{--
  內頁主視覺 page-banner

  - 圖片：config.php pageBanners[bannerKey]（後台可換）
  - 標題文案 eyebrow／enTitle：各頁 include 傳入（固定文字，不進後台）
  - showVeil：是否顯示深色遮罩（預設 true）
  - tone：light（白字，預設）／dark（深色字）
  - compact：較矮高度（法規頁用）
--}}
@php
    $banners = gretech_as_array($page->pageBanners ?? []);
    $bannerKey = $bannerKey ?? null;
    $fromConfig = ($bannerKey && isset($banners[$bannerKey]) && is_array($banners[$bannerKey]))
        ? $banners[$bannerKey]
        : [];
    $defaultBanner = is_array($banners['default'] ?? null) ? $banners['default'] : [];

    $bannerImage = $bgImage
        ?? ($fromConfig['image'] ?? null)
        ?? $page->bannerImage
        ?? ($defaultBanner['image'] ?? 'banner_default.jpg');
    $bannerImage = trim((string) $bannerImage);

    if ($bannerImage === '') {
        $bannerImage = $defaultBanner['image'] ?? 'banner_default.jpg';
    }

    if (!str_starts_with($bannerImage, '/') && !str_starts_with($bannerImage, 'http://') && !str_starts_with($bannerImage, 'https://')) {
        $bannerImage = '/images/' . ltrim($bannerImage, '/');
    }

    $eyebrow = $eyebrow ?? '';
    $enTitle = $enTitle ?? '';
    $showVeil = $showVeil ?? true;
    $tone = ($tone ?? 'light') === 'dark' ? 'dark' : 'light';
    $compact = (bool) ($compact ?? false);

    $isDark = $tone === 'dark';
    $crumbClass = $isDark ? 'text-gray4' : 'text-white';
    $crumbCurrentClass = $isDark ? 'text-gray4' : 'text-white';
    $eyebrowClass = $isDark ? 'text-gray3' : 'text-gray1';
    $titleClass = $isDark ? 'text-gray5' : 'text-gray1';

    $sectionClass = trim(implode(' ', [
        'page-banner',
        'relative overflow-hidden',
        $compact ? 'page-banner--compact' : '',
        $isDark ? 'page-banner--dark' : '',
    ]));
@endphp
<section class="{{ $sectionClass }}" aria-label="{{ $enTitle !== '' ? $enTitle : ($crumbs[0]['name'] ?? '') }}">
    {{-- 背景圖（等載入後由 JS 加 is-ready 再淡入） --}}
    <img
        src="{{ $page->baseUrl }}{{ $bannerImage }}"
        alt=""
        class="page-banner-image absolute inset-0 h-full w-full object-cover"
        width="1920"
        height="880"
        decoding="async"
        fetchpriority="high"
        aria-hidden="true"
    >
    {{-- 背景遮罩（加深圖片，讓白字清楚；可傳 showVeil => false 關閉） --}}
    @if ($showVeil)
        <div class="page-banner-veil absolute inset-0 bg-gray5/30" aria-hidden="true"></div>
    @endif

    <div class="layout-grid relative z-10 flex h-full flex-col pt-4 pb-12">
        {{-- 麵包屑（右上；手機單行，最後一項過長省略） --}}
        <div class="page-banner-crumbs flex w-full min-w-0 items-center justify-end gap-1.5">
            <a href="{{ $page->baseUrl }}/" class="page-banner-crumb-home inline-flex shrink-0 items-center {{ $crumbClass }} transition-opacity duration-200 ease-in-out hover:opacity-75" aria-label="首頁">
                <i data-lucide="home" class="h-4 w-4"></i>
            </a>
            @if (!empty($crumbs))
                @foreach ($crumbs as $crumb)
                    <span class="page-banner-crumb-sep text-eb3 shrink-0 {{ $crumbClass }}" aria-hidden="true">・</span>
                    @if (!empty($crumb['link']))
                        <a href="{{ $crumb['link'] }}" class="page-banner-crumb-link text-cb3 shrink-0 {{ $crumbClass }} transition-opacity duration-200 ease-in-out hover:opacity-75">{{ $crumb['name'] }}</a>
                    @else
                        <span class="page-banner-crumb-current text-cb3 min-w-0 truncate {{ $crumbCurrentClass }}" title="{{ $crumb['name'] }}">{{ $crumb['name'] }}</span>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- 置中標題區（進入：模糊 → 清楚） --}}
        <div class="page-banner-title flex flex-1 flex-col items-center justify-center gap-3.5">
            <div class="flex w-full flex-col items-center">
                @if ($eyebrow !== '')
                    <p class="text-center font-outfit text-sm font-normal tracking-[0.3em] {{ $eyebrowClass }}">{{ $eyebrow }}</p>
                @endif
                @if ($enTitle !== '')
                    <h1 class="text-center font-outfit text-[2.75rem] font-light leading-[1.1] tracking-[0.06em] {{ $titleClass }} md:text-[64px]">
                        {{ $enTitle }}
                    </h1>
                @endif
            </div>
            <div class="title-rule" aria-hidden="true"></div>
        </div>
    </div>
</section>
