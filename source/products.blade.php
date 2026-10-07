---
title: 產品介紹
description: 產品介紹
---
@extends('_layouts.main')

@section('body')
    @php
        $catalog = $page->productCatalog ?? [];
        $defaultL1 = $catalog[0]['id'] ?? '';
        $defaultL2 = $catalog[0]['categories'][0]['id'] ?? '';
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'products',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'PRODUCTS',
        'crumbs' => [['name' => '產品介紹']],
    ])

    <section
        class="products-page bg-bg"
        aria-label="產品介紹"
        data-products-catalog
        data-default-l1="{{ $defaultL1 }}"
        data-default-l2="{{ $defaultL2 }}"
    >
        {{-- 第一層分類：貼齊 banner 下方，等寬分欄＋底線高亮 --}}
        <nav class="products-l1-nav" data-products-l1-nav aria-label="產品大類" data-aos="fade-up">
            <div class="products-l1" role="tablist" data-products-l1-track>
                @foreach ($catalog as $l1)
                    <button
                        type="button"
                        class="products-l1-btn text-cb2 md:text-cb1 {{ $loop->first ? 'is-active' : '' }}"
                        role="tab"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        data-products-l1="{{ $l1['id'] }}"
                    >{{ $l1['name'] }}</button>
                @endforeach
            </div>
        </nav>

        <div class="layout-grid flex flex-col gap-6 pt-10 pb-24 md:gap-12 md:pt-14 md:pb-28">
            <div class="flex flex-col gap-6 md:flex-row md:items-start md:gap-10" data-aos="fade-up" data-aos-delay="50">
                {{-- 第二層：手機下拉選單／桌機側欄 --}}
                <aside class="products-l2" aria-label="產品分類" data-products-l2-nav>
                    <button
                        type="button"
                        class="products-l2-toggle text-cb2"
                        data-products-l2-toggle
                        aria-expanded="false"
                        aria-controls="products-l2-menu"
                    >
                        <span data-products-l2-label>{{ $catalog[0]['categories'][0]['name'] ?? '選擇分類' }}</span>
                        <i data-lucide="chevron-down" class="products-l2-chevron h-4 w-4" aria-hidden="true"></i>
                    </button>

                    <div id="products-l2-menu" class="products-l2-menu" data-products-l2-menu>
                        @foreach ($catalog as $l1)
                            <div
                                class="products-l2-panel {{ $loop->first ? 'is-active' : '' }}"
                                data-products-l2-panel="{{ $l1['id'] }}"
                                @if (!$loop->first) hidden @endif
                            >
                                @foreach ($l1['categories'] as $l2)
                                    <button
                                        type="button"
                                        class="products-l2-btn text-cb2 {{ $loop->parent->first && $loop->first ? 'is-active' : '' }}"
                                        data-products-l2="{{ $l2['id'] }}"
                                        data-products-l1-ref="{{ $l1['id'] }}"
                                    >{{ $l2['name'] }}</button>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </aside>

                {{-- 產品列表 --}}
                <div class="products-main">
                    @foreach ($catalog as $l1)
                        @foreach ($l1['categories'] as $l2)
                            <div
                                class="products-l3-panel {{ $loop->parent->first && $loop->first ? 'is-active' : '' }}"
                                data-products-l3-panel="{{ $l2['id'] }}"
                                data-products-l1-ref="{{ $l1['id'] }}"
                                @if (!($loop->parent->first && $loop->first)) hidden @endif
                            >
                                <div class="flex flex-col items-start gap-3 mb-6">
                                    <h3 class="text-ch4 md:text-ch3 text-gray5">{{ $l2['name'] }}</h3>
                                    <div class="title-rule" aria-hidden="true"></div>
                                </div>

                                <ul class="products-list">
                                    @foreach (($l2['products'] ?? []) as $product)
                                        <li>
                                            <a
                                                href="{{ $page->baseUrl }}/products/{{ $product['slug'] }}/"
                                                class="products-item"
                                            >
                                                @if (!empty($product['image']))
                                                    <span class="products-item-media">
                                                        <img
                                                            src="{{ $page->baseUrl }}{{ $product['image'] }}"
                                                            alt=""
                                                            loading="lazy"
                                                        >
                                                    </span>
                                                @else
                                                    <span class="products-item-media products-item-media--empty" aria-hidden="true"></span>
                                                @endif
                                                <span class="products-item-name text-cb2 text-gray5">{{ $product['title'] }}</span>
                                                <i data-lucide="chevron-right" class="products-item-arrow h-4 w-4" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
