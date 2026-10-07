@extends('_layouts.main')

@section('body')
    @php
        $body = trim((string) ($page->body ?? ''));
        if ($body === '') {
            $body = trim((string) ($page->intro ?? ''));
        }
        $paragraphs = $body !== '' ? preg_split("/\n\s*\n/", $body) : [];
        $tags = [];
        foreach (is_array($page->tags ?? null) ? $page->tags : [] as $tag) {
            $tag = trim((string) $tag);
            if ($tag !== '') {
                $tags[] = $tag;
            }
        }
        $image = $page->image ?? '';
        $listUrl = $page->baseUrl . '/applications/';
        $category = trim((string) ($page->category ?? ''));
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'applications',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'APPLICATIONS',
        'crumbs' => [
            ['name' => '應用領域', 'link' => $listUrl],
            ['name' => $page->title],
        ],
    ])

    <section class="product-detail-page bg-bg" aria-label="{{ $page->title }}">
        <div class="layout-grid py-16 md:py-20 lg:py-28">
            <div class="product-detail" data-aos="fade-up">
                <div class="product-detail-media product-detail-media--cover {{ $image ? '' : 'product-detail-media--empty' }}">
                    @if ($image)
                        <img
                            src="{{ $page->baseUrl }}{{ $image }}"
                            alt="{{ $page->title }}"
                            loading="eager"
                        >
                    @endif
                </div>

                <div class="product-detail-copy">
                    <div class="product-detail-heading">
                        @if ($category !== '')
                            <p class="product-detail-crumb text-cb3 text-gray3">{{ $category }}</p>
                        @endif
                        <h2 class="product-detail-title text-ch4 text-gray5 md:text-ch3">{{ $page->title }}</h2>
                        <div class="title-rule" aria-hidden="true"></div>
                    </div>

                    <div class="product-detail-body">
                        @foreach ($paragraphs as $paragraph)
                            <p class="text-cb2 text-gray4 whitespace-pre-line">{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    @if (count($tags) > 0)
                        <div class="product-detail-tags">
                            <p class="product-detail-tags-label text-cb1 text-gray5">主要應用</p>
                            <ul class="product-detail-tags-list">
                                @foreach ($tags as $tag)
                                    <li class="product-detail-tag">{{ $tag }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="product-detail-actions">
                        <a href="{{ $page->baseUrl }}/contact/" class="btn-solid">
                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                            <span>聯絡我們</span>
                        </a>
                        <a href="{{ $listUrl }}" class="product-detail-back text-cb2">
                            <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                            返回應用列表
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
