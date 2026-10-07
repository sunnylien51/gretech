@extends('_layouts.main')

@section('body')
    @php
        $intro = trim((string) ($page->intro ?? ''));
        $paragraphs = $intro !== '' ? preg_split("/\n\s*\n/", $intro) : [];
        $image = $page->image ?? '';
        $l1Id = trim((string) ($page->l1_id ?? ''));
        $l2Id = trim((string) ($page->l2_id ?? ''));
        $productsListQuery = http_build_query(array_filter([
            'l1' => $l1Id !== '' ? $l1Id : null,
            'l2' => $l2Id !== '' ? $l2Id : null,
        ]));
        $productsListUrl = $page->baseUrl . '/products/' . ($productsListQuery !== '' ? '?' . $productsListQuery : '');
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'products',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'PRODUCTS',
        'crumbs' => [
            ['name' => '產品介紹', 'link' => $productsListUrl],
            ['name' => $page->title],
        ],
    ])

    <section class="product-detail-page bg-bg" aria-label="{{ $page->title }}">
        <div class="layout-grid py-16 md:py-20 lg:py-28">
            <div class="product-detail" data-aos="fade-up">
                <div class="product-detail-media {{ $image ? '' : 'product-detail-media--empty' }}">
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
                        <p class="product-detail-crumb text-cb3 text-gray3">
                            {{ $page->l1_name }} ・ {{ $page->l2_name }}
                        </p>
                        <h2 class="product-detail-title text-ch4 text-gray5 md:text-ch3">{{ $page->title }}</h2>
                        <div class="title-rule" aria-hidden="true"></div>
                    </div>

                    <div class="product-detail-body">
                        @foreach ($paragraphs as $paragraph)
                            <p class="text-cb2 text-gray4">{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    <div class="product-detail-actions">
                        <a href="{{ $page->baseUrl }}/contact/" class="btn-solid">
                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                            <span>聯絡我們</span>
                        </a>
                        <a href="{{ $productsListUrl }}" class="product-detail-back text-cb2">
                            <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                            返回產品列表
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
