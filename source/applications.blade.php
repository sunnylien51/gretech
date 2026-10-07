---
title: 應用領域
description: 應用領域
---
@extends('_layouts.main')

@section('body')
    @php
        $applicationGroups = [];
        foreach ($page->applicationCategories as $category) {
            $applicationGroups[$category] = [];
        }
        foreach ($page->applications as $app) {
            $category = $app['category'] ?? '';
            if (!array_key_exists($category, $applicationGroups)) {
                $applicationGroups[$category] = [];
            }
            $applicationGroups[$category][] = $app;
        }
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'applications',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'APPLICATIONS',
        'crumbs' => [['name' => '應用領域']],
    ])

    <section class="applications-page bg-bg" aria-label="應用領域">
        <div class="layout-grid flex flex-col gap-16 py-16 md:gap-20 md:py-20 lg:gap-24 lg:py-28">

            @foreach ($applicationGroups as $category => $apps)
                @if (count($apps) > 0)
                    <div
                        class="applications-group flex flex-col gap-8 md:gap-10"
                        id="applications-{{ $loop->index + 1 }}"
                        data-aos="fade-up"
                    >
                        <div class="flex flex-col items-start gap-4">
                            <h3 class="text-ch4 text-gray5 lg:text-ch3">{{ $category }}</h3>
                            <div class="title-rule" aria-hidden="true"></div>
                        </div>

                        <div class="applications-grid">
                            @foreach ($apps as $app)
                                <a
                                    href="{{ $page->baseUrl }}/applications/{{ $app['slug'] }}/"
                                    class="applications-card"
                                    data-aos="fade-up"
                                    data-aos-delay="{{ min($loop->index * 50, 200) }}"
                                >
                                    <div class="applications-card-media">
                                        <img
                                            src="{{ $page->baseUrl }}{{ $app['image'] }}"
                                            alt="{{ $app['title'] }}"
                                            class="applications-card-image"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="applications-card-body">
                                        <span class="applications-card-tab">{{ $app['category'] }}</span>
                                        <h4 class="applications-card-title text-ch5 text-gray5">{{ $app['title'] }}</h4>
                                        <p class="applications-card-intro text-cb3 text-gray4">{{ $app['intro'] }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
