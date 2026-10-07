{{--
  法規／說明頁標題區（無 Banner 圖；麵包屑／標題位置與 page-banner 相同）
  參數：$title（必填）、$enTitle（選填）、$eyebrow（選填）、$crumbs（選填）
--}}
@php
    $title = $title ?? '';
    $enTitle = $enTitle ?? '';
    $eyebrow = $eyebrow ?? '';
    $crumbs = $crumbs ?? [['name' => $title]];
@endphp

<section class="legal-header relative overflow-hidden" aria-label="{{ $enTitle !== '' ? $enTitle : $title }}">
    <div class="layout-grid relative z-10 flex h-full flex-col pt-4 pb-12">
        {{-- 麵包屑（右上；與 page-banner 同位置） --}}
        <div class="page-banner-crumbs flex w-full min-w-0 items-center justify-end gap-1.5">
            <a href="{{ $page->baseUrl }}/" class="page-banner-crumb-home inline-flex shrink-0 items-center text-gray4 transition-opacity duration-200 ease-in-out hover:opacity-75" aria-label="首頁">
                <i data-lucide="home" class="h-4 w-4"></i>
            </a>
            @if (!empty($crumbs))
                @foreach ($crumbs as $crumb)
                    <span class="page-banner-crumb-sep text-eb3 shrink-0 text-gray3" aria-hidden="true">・</span>
                    @if (!empty($crumb['link']))
                        <a href="{{ $crumb['link'] }}" class="page-banner-crumb-link text-cb3 shrink-0 text-gray4 transition-opacity duration-200 ease-in-out hover:opacity-75">{{ $crumb['name'] }}</a>
                    @else
                        <span class="page-banner-crumb-current text-cb3 min-w-0 truncate text-gray5" title="{{ $crumb['name'] }}">{{ $crumb['name'] }}</span>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- 置中標題區（與 page-banner 同位置） --}}
        <div class="page-banner-title flex flex-1 flex-col items-center justify-center gap-3.5">
            <div class="flex w-full flex-col items-center">
                @if ($eyebrow !== '')
                    <p class="text-center font-outfit text-sm font-normal tracking-[0.3em] text-gray3">{{ $eyebrow }}</p>
                @endif
                @if ($enTitle !== '')
                    <h1 class="text-center font-outfit text-[2.75rem] font-light leading-[1.1] tracking-[0.06em] text-gray5 md:text-[64px]">
                        {{ $enTitle }}
                    </h1>
                @elseif ($title !== '')
                    <h1 class="text-center text-ch3 text-gray5 lg:text-ch2">{{ $title }}</h1>
                @endif
            </div>
            <div class="title-rule" aria-hidden="true"></div>
        </div>
    </div>
</section>
