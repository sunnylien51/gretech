@extends('_layouts.main')

@section('body')
    @php
        $slides = $page->heroSlides ?? [];
        $slideCount = count($slides);
    @endphp

    {{-- ========== Hero 主視覺輪播 ========== --}}
    <section
        id="hero-swiper"
        class="hero-swiper relative w-full overflow-hidden h-[520px] md:h-[600px] lg:h-[680px]"
        data-slides="{{ $slideCount }}"
        aria-label="首頁主視覺"
    >
        {{-- 輪播投影片 --}}
        <div class="swiper-wrapper">
            @foreach ($slides as $slide)
                <div class="swiper-slide hero-slide">
                    {{-- 背景圖 --}}
                    <img
                        src="{{ $page->baseUrl }}{{ $slide['image'] }}"
                        alt="{{ $slide['enTitle'] }}"
                        class="hero-slide-image absolute inset-0 h-full w-full object-cover"
                    >
                    {{-- 文案區（左上） --}}
                    <div class="relative z-10 flex h-full flex-col justify-start layout-grid pt-20 pb-24 md:pt-28 lg:pt-40">
                        <div class="hero-copy flex w-full max-w-[580px] flex-col items-start gap-2">
                            {{-- 英文主標題 --}}
                            <h1 class="text-eh3 text-white md:text-eh2 lg:text-eh1">{{ $slide['enTitle'] }}</h1>
                            {{-- 中文副標／說明 --}}
                            <p class="text-cb2 text-white">{{ $slide['zhText'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 底部導覽：上一張 / 進度條 / 下一張 --}}
        <div class="hero-controls pointer-events-none absolute inset-x-0 bottom-0 z-10 layout-grid pb-8 lg:pb-10">
            <div class="pointer-events-auto inline-flex items-center gap-3">
                {{-- 上一張 --}}
                <button type="button" class="hero-nav-btn" data-hero-prev aria-label="上一張">
                    <i data-lucide="chevron-left" class="h-5 w-5 text-white"></i>
                </button>
                {{-- 頁碼＋進度條 --}}
                <div class="flex w-44 items-center gap-2.5">
                    <span class="text-eb3 text-white" data-hero-current>1</span>
                    <div class="relative h-0.5 w-36 overflow-hidden rounded-[10px] bg-white/50">
                        {{-- 進度條（寬度由 JS 控制） --}}
                        <div class="hero-progress-bar h-full rounded-[10px] bg-white" data-hero-progress style="width: {{ $slideCount ? round(100 / $slideCount, 2) : 0 }}%"></div>
                    </div>
                    <span class="text-eb3 text-white" data-hero-total>{{ $slideCount }}</span>
                </div>
                {{-- 下一張 --}}
                <button type="button" class="hero-nav-btn" data-hero-next aria-label="下一張">
                    <i data-lucide="chevron-right" class="h-5 w-5 text-white"></i>
                </button>
            </div>
        </div>
    </section>

    {{-- ========== About 關於我們（資料：config homeAbout） ========== --}}
    @php
        $homeAbout = $page->homeAbout ?? [];
        $homeAboutStats = $homeAbout['stats'] ?? [];
        $homeAboutTitleHtml = nl2br(e($homeAbout['title'] ?? ''));
        $homeAboutBodyHtml = nl2br(e($homeAbout['body'] ?? ''));
        $homeAboutImage = $homeAbout['image'] ?? '/images/about1.jpg';
    @endphp
    <section class="bg-[radial-gradient(at_0%_0%,#FFFFFF_0%,#F5F5F5_45%,#E0E7FF_100%)] pt-16 md:pt-20 lg:pt-[120px]" aria-label="關於我們">
        <div class="flex flex-col items-stretch md:flex-row md:items-end">
            {{-- 左側：圖片拼貼（SVG mask 造型） --}}
            <div class="relative w-full shrink-0 pr-6 pl-0 md:w-1/2 md:pr-10 lg:pr-[100px]" data-aos="fade-right">
                {{-- 主圖（object_cover.svg 遮罩） --}}
                <div class="about-visual-mask aspect-[800/732] w-full overflow-hidden">
                    <img
                        src="{{ $page->baseUrl }}{{ $homeAboutImage }}"
                        alt="關於我們"
                        class="h-full w-full object-cover"
                    >
                </div>
                {{-- Founded 徽章（圓形＋裝飾線） --}}
                <div class="absolute bottom-6 right-6 z-10 translate-y-1/4 md:bottom-10 md:right-10 md:translate-x-1/4 md:translate-y-0 lg:bottom-[120px] lg:right-[100px] lg:translate-x-1/3" data-aos="zoom-in" data-aos-delay="200">
                    {{-- 裝飾 SVG --}}
                    <img
                        src="{{ $page->baseUrl }}/images/dec.svg"
                        alt=""
                        aria-hidden="true"
                        class="pointer-events-none absolute left-1/2 top-1/2 size-40 max-w-none -translate-x-1/2 -translate-y-1/2 md:size-44 lg:size-[13.3125rem]"
                    >
                    {{-- Founded 圓標 --}}
                    <div class="relative inline-flex size-32 flex-col items-center justify-center rounded-[89px] bg-main1 text-center text-white md:size-36 lg:size-[168px]" aria-label="成立於 2002 年">
                        <span class="text-eb2">Founded</span>
                        <span class="text-eh3 lg:text-eh2">2002</span>
                        <i data-lucide="plus" class="mt-0.5 h-4 w-4 text-white" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            {{-- 右側：文案＋統計 --}}
            <div class="relative flex w-full flex-col items-start gap-10 border-t border-gray5/20 px-6 pt-14 pb-20 md:w-1/2 md:gap-10 md:border-l md:border-t-0 md:px-10 md:pt-8 md:pb-16 lg:gap-14 lg:px-0 lg:pt-10 lg:pb-[120px] lg:pl-[100px] lg:pr-[120px]" data-aos="fade-left" data-aos-delay="100">
                {{-- 強調邊線（手機橫線／桌機豎線） --}}
                <div class="absolute left-[-1px] top-[-1.5px] h-0.5 w-40 bg-main2 md:top-0 md:h-40 md:w-0.5 lg:h-48" aria-hidden="true"></div>

                {{-- 標題＋內文 --}}
                <div class="flex w-full flex-col items-start gap-5 md:gap-6">
                    <h2 class="text-ch3 text-gray5 lg:text-ch2">{!! $homeAboutTitleHtml !!}</h2>
                    <p class="text-cb2 text-gray4">{!! $homeAboutBodyHtml !!}</p>
                </div>

                {{-- 統計列 --}}
                @if (count($homeAboutStats) > 0)
                <div class="flex w-full flex-col gap-5 md:flex-row md:items-center md:gap-9">
                    @foreach ($homeAboutStats as $stat)
                        @if (!$loop->first)
                            <div class="h-px w-full bg-gray2 md:h-16 md:w-px md:shrink-0" aria-hidden="true"></div>
                        @endif
                        <div class="flex flex-1 flex-col items-center gap-1.5" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 100) }}">
                            <div class="flex items-end gap-2">
                                <span class="text-eh3 text-main1 lg:text-eh2">{{ $stat['value'] ?? '' }}</span>
                                <span class="pb-1 text-cb3 text-gray5">{{ $stat['unit'] ?? '' }}</span>
                            </div>
                            <p class="text-center text-cb3 text-gray5">{{ $stat['label'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ========== 應用區域 ========== --}}
    <section
        id="home-applications"
        class="apps-section relative flex flex-col items-center overflow-x-hidden py-16 md:py-20 lg:py-28"
        aria-label="應用領域"
        data-aos="fade-up"
    >
        {{-- 區塊標題＋底線（置中，沿用 title-rule） --}}
        <div class="flex flex-col items-center gap-5 mb-16" data-aos="fade-up">
            <h2 class="text-center text-ch3 text-gray5 lg:text-ch2">應用領域</h2>
            <div class="title-rule" aria-hidden="true"></div>
        </div>

        @php
            $homeApplications = gretech_home_applications(
                $page->applications ?? [],
                (int) ($page->homeApplicationsLimit ?? 10)
            );
        @endphp

        {{-- 單卡寬軌道 + overflow 露出鄰卡（與應用領域連動，可上下架於首頁） --}}
        <div class="apps-carousel-wrap">
            <div
                id="apps-swiper"
                class="apps-swiper swiper"
                data-slides="{{ count($homeApplications) }}"
            >
                <div class="swiper-wrapper">
                    @foreach ($homeApplications as $app)
                        <div class="swiper-slide apps-slide">
                            <a
                                href="{{ $page->baseUrl }}/applications/{{ $app['slug'] }}/"
                                class="app-card"
                            >
                                <img
                                    src="{{ $page->baseUrl }}{{ $app['image'] }}"
                                    alt="{{ $app['title'] }}"
                                    class="app-card-image"
                                >
                                <div class="app-card-shade" aria-hidden="true"></div>
                                <div class="app-card-gradient" aria-hidden="true"></div>
                                <div class="app-card-content">
                                    <span class="app-card-tab">{{ $app['category'] }}</span>
                                    <h3 class="app-card-title text-ch4 text-white">{{ $app['title'] }}</h3>
                                    <p class="app-card-intro text-cb3 text-white/90">{{ $app['intro'] }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <nav class="apps-controls" aria-label="應用區域導覽">
            <button type="button" class="apps-nav-btn" data-apps-prev aria-label="上一個應用">
                <i data-lucide="chevron-left" class="h-5 w-5" aria-hidden="true"></i>
            </button>
            <div class="apps-pagination" data-apps-pagination></div>
            <button type="button" class="apps-nav-btn" data-apps-next aria-label="下一個應用">
                <i data-lucide="chevron-right" class="h-5 w-5" aria-hidden="true"></i>
            </button>
        </nav>
    </section>

    {{-- ========== 產品介紹（資料來源：config productCatalog，與產品內頁同一筆） ========== --}}
    @php
        $homeProducts = gretech_home_products(
            $page->productCatalog ?? [],
            (int) ($page->homeProductsLimit ?? 12)
        );
        $homeProduct = $homeProducts[0] ?? null;
    @endphp
    @if ($homeProduct)
    <section
        id="home-products"
        class="history-section relative overflow-hidden"
        aria-label="產品介紹"
        data-aos="fade-up"
    >
        <script type="application/json" id="home-products-data">{!! json_encode($homeProducts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

        {{-- 裝飾大字 PRODUCT：裁切浮水印，疊進區塊 --}}
        <div class="product-watermark" aria-hidden="true">
            <div class="layout-grid">
                <span class="product-watermark-text">PRODUCT</span>
            </div>
        </div>

        <div class="relative z-10 flex flex-col gap-14 pt-20 pb-16 md:pt-28 md:pb-20 lg:pt-32 lg:pb-28">

            {{-- 上：文案＋主圖（右側大圖區貼齊視窗右緣） --}}
            <div class="product-featured flex w-full flex-col items-stretch gap-12 lg:flex-row lg:items-center lg:gap-0" data-product-drag>
                {{-- 左側文案 --}}
                <div class="product-copy flex w-full flex-col items-start gap-8" data-aos="fade-right">
                    {{-- 標題區（左框線） --}}
                    <div class="flex w-full items-center gap-4 border-l-2 border-main2 pl-6">
                        <div class="flex min-w-0 flex-1 flex-col items-start gap-2">
                            <h3 class="product-title text-ch3 text-main1 lg:text-[2rem] lg:leading-10" data-product-title>
                                {{ $homeProduct['title'] }}
                            </h3>
                            <p class="product-subtitle text-cb1 text-gray5" data-product-subtitle>
                                {{ $homeProduct['subtitle'] }}
                            </p>
                        </div>
                    </div>

                    {{-- 說明 --}}
                    <p class="product-desc line-clamp-3 text-cb2 text-gray4" data-product-desc>
                        {{ $homeProduct['description'] }}
                    </p>

                    {{-- 切換控制：上一／下一＋頁碼 --}}
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <button type="button" class="product-nav-btn" data-product-prev aria-label="上一個產品">
                                <i data-lucide="chevron-left" class="h-5 w-5" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="product-nav-btn product-nav-btn--next" data-product-next aria-label="下一個產品">
                                <i data-lucide="chevron-right" class="h-5 w-5" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="flex items-baseline gap-2 font-outfit tracking-tight">
                            <span class="text-base text-gray5" data-product-current>01</span>
                            <span class="text-sm font-medium text-gray3">/</span>
                            <span class="text-sm font-medium text-gray3" data-product-total>{{ str_pad((string) count($homeProducts), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                {{-- 右側主圖：底條在文件流，大圖 absolute 疊上並往上偏移 --}}
                <div class="product-visual relative flex w-full flex-1 flex-col items-center justify-center lg:pl-20" data-aos="fade-left" data-aos-delay="100">
                    <div class="product-visual-shape" aria-hidden="true"></div>
                    <img
                        src="{{ $page->baseUrl }}{{ $homeProduct['image'] }}"
                        alt="{{ $homeProduct['title'] }}"
                        class="product-visual-image"
                        data-product-image
                    >
                </div>
            </div>

            {{-- 下：縮圖列（Swiper 一次滑一格，螢幕上仍可同時看到多張） --}}
            <div class="layout-grid flex flex-col items-center gap-6" data-aos="fade-up" data-aos-delay="150">
                <div
                    id="product-thumbs-swiper"
                    class="product-thumbs-swiper swiper w-full"
                    data-product-thumbs-swiper
                >
                    <div class="swiper-wrapper">
                        @foreach ($homeProducts as $index => $product)
                            <div class="swiper-slide product-thumbs-slide">
                                <button
                                    type="button"
                                    class="product-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                    data-product-thumb="{{ $index }}"
                                    aria-label="{{ $product['title'] }}"
                                    aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                                >
                                    <span class="product-thumb-media">
                                        <img src="{{ $page->baseUrl }}{{ $product['thumb'] }}" alt="" aria-hidden="true">
                                    </span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
