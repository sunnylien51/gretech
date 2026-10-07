---
title: 關於我們
description: 關於我們
---
@extends('_layouts.main')

@section('body')
    @include('_components.page-banner', [
        'bannerKey' => 'about',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'ABOUT',
        'crumbs' => [['name' => '關於我們']],
    ])

    {{-- ========== 關於我們＋經營理念 ========== --}}
    <section class="bg-white" aria-label="關於我們">
    <div class="layout-grid flex flex-col gap-16 py-16 md:gap-20 md:py-20 lg:gap-24 lg:py-28">

        {{-- ----- 上：關於我們介紹 ----- --}}
        <div class="flex w-full flex-col items-center gap-12 lg:flex-row lg:items-center lg:gap-20">
            {{-- 左側：標題／內文／統計 --}}
            <div class="flex w-full flex-1 flex-col items-start gap-10 md:gap-12" data-aos="fade-up">
                {{-- 區塊標題＋底線 --}}
                <div class="flex flex-col items-start gap-5">
                    <h2 class="text-ch3 text-gray5 lg:text-ch2">關於我們</h2>
                    {{-- 底線（雙色短線） --}}
                    <div class="title-rule" aria-hidden="true"></div>
                </div>

                {{-- 主標＋說明 --}}
                <div class="flex w-full flex-col items-start gap-5">
                    <h3 class="text-ch3 text-gray5">
                        專注 PCB 產業，串聯產品、技術與製程需求
                    </h3>
                    <p class="text-cb2 text-gray4">
                        佢朋專注於 PCB 及 IC 產業，提供設備、原物料、耗材、零組件及技術服務，致力於為客戶打造快速、穩定且具效率的整合服務。<br>
                        透過與國內外專業供應商的長期合作，我們持續掌握產業技術與市場趨勢，積極導入新產品與新技術，協助客戶提升設備效率、優化製程、降低生產成本，並確保關鍵產品與零組件的穩定供應。<br>
                        從產品供應到技術整合，佢朋致力於成為 PCB 產業值得信賴的長期合作夥伴。
                    </p>
                </div>

                {{-- 統計列 --}}
                <div class="flex w-full flex-col gap-5 md:flex-row md:items-center md:gap-9">
                    {{-- 統計 1：團隊人數 --}}
                    <div class="flex flex-1 flex-col items-center gap-1.5" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-end gap-2">
                            <span class="text-eh3 text-main1 lg:text-eh2">50</span>
                            <span class="pb-1 text-cb3 text-gray5">位</span>
                        </div>
                        <p class="text-center text-cb3 text-gray5">擁有專業經驗的團隊成員</p>
                    </div>
                    {{-- 分隔線 --}}
                    <div class="h-px w-full bg-gray2 md:h-16 md:w-px md:shrink-0" aria-hidden="true"></div>
                    {{-- 統計 2：資本額 --}}
                    <div class="flex flex-1 flex-col items-center gap-1.5" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex items-end gap-2">
                            <span class="text-eh3 text-main1 lg:text-eh2">2.18</span>
                            <span class="pb-1 text-cb3 text-gray5">億</span>
                        </div>
                        <p class="text-center text-cb3 text-gray5">實收資本額</p>
                    </div>
                    {{-- 分隔線 --}}
                    <div class="h-px w-full bg-gray2 md:h-16 md:w-px md:shrink-0" aria-hidden="true"></div>
                    {{-- 統計 3：據點數 --}}
                    <div class="flex flex-1 flex-col items-center gap-1.5" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-end gap-2">
                            <span class="text-eh3 text-main1 lg:text-eh2">3</span>
                            <span class="pb-1 text-cb3 text-gray5">個</span>
                        </div>
                        <p class="text-center text-cb3 text-gray5">營運核心據點</p>
                    </div>
                </div>
            </div>

            {{-- 右側：造型圖＋ Founded 徽章 --}}
            <div class="relative w-full flex-1" data-aos="fade-left" data-aos-delay="150">
                {{-- 主圖（已含造型遮罩的 PNG） --}}
                <img
                    src="{{ $page->baseUrl }}/images/about2.png"
                    alt="精密製程與 IC 元件"
                    class="mx-auto h-auto w-full max-w-md lg:max-w-none"
                >
                {{-- Founded 徽章 --}}
                <img
                    src="{{ $page->baseUrl }}/images/founded.png"
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute top-[6%] left-[1.5%] md:left-[26%] lg:left-[4%] w-28 md:w-36 lg:w-[10.5rem]"
                >
            </div>
        </div>

        {{-- ----- 下：經營理念 ----- --}}
        <div class="flex w-full flex-col items-start gap-10 md:gap-12" data-aos="fade-up">
            {{-- 區塊標題＋底線 --}}
            <div class="flex flex-col items-start gap-5">
                <h2 class="text-ch3 text-gray5 lg:text-ch2">經營理念</h2>
                {{-- 底線（雙色短線） --}}
                <div class="title-rule" aria-hidden="true"></div>
            </div>

            {{-- 理念三欄 --}}
            <div class="flex w-full flex-col gap-6 md:flex-row md:gap-8 lg:gap-12">
                {{-- 理念 1：嚴選品質 --}}
                <div class="philosophy-card flex flex-1 flex-col gap-3 border-l-[3px] border-main2 px-6 py-6 md:px-8 md:py-7" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-ch4 text-gray5">嚴選品質</h3>
                    <p class="text-cb2 text-gray3">嚴選業界優質產品，提供值得信賴的產品與解決方案。</p>
                </div>
                {{-- 理念 2：誠信經營 --}}
                <div class="philosophy-card flex flex-1 flex-col gap-3 border-l-[3px] border-main2 px-6 py-6 md:px-8 md:py-7" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-ch4 text-gray5">誠信經營</h3>
                    <p class="text-cb2 text-gray3">堅持誠信、務實與負責的態度，與客戶及合作夥伴建立長期信任。</p>
                </div>
                {{-- 理念 3：服務至上 --}}
                <div class="philosophy-card flex flex-1 flex-col gap-3 border-l-[3px] border-main2 px-6 py-6 md:px-8 md:py-7" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-ch4 text-gray5">服務至上</h3>
                    <p class="text-cb2 text-gray3">深入了解客戶需求，提供專業、快速且有效率的服務，創造長期合作價值。</p>
                </div>
            </div>
        </div>
    </div>
    </section>

    {{-- ========== 公司沿革（資料：config companyHistory） ========== --}}
    @php
        $history = $page->companyHistory ?? [];
    @endphp
    <section class="history-section relative overflow-hidden" aria-label="公司沿革">
        {{-- 裝飾大字 HISTORY：裁切浮水印 --}}
        <div class="section-watermark" aria-hidden="true">
            <div class="layout-grid">
                <span class="section-watermark-text">HISTORY</span>
            </div>
        </div>

        <div class="layout-grid relative z-10 flex flex-col items-center gap-12 py-16 md:gap-14 md:py-20 lg:gap-16 lg:pt-24 lg:pb-28">
            {{-- 區塊標題＋底線（置中） --}}
            <div class="flex flex-col items-center gap-5" data-aos="fade-up">
                <h2 class="text-center text-ch3 text-gray5 lg:text-ch2">公司沿革</h2>
                <div class="title-rule" aria-hidden="true"></div>
            </div>

            {{-- 時間軸列表 --}}
            <div class="flex w-full max-w-[900px] flex-col items-start">
                @foreach ($history as $item)
                    <div class="history-item flex w-full items-start gap-4 md:gap-6" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 50, 300) }}">
                        {{-- 年份 --}}
                        <div class="w-14 shrink-0 font-outfit text-2xl font-medium tracking-wide text-main1 md:w-20 md:text-eh3">
                            {{ $item['year'] }}
                        </div>
                        {{-- 圓點＋連線 --}}
                        <div class="flex shrink-0 flex-col items-center gap-1 self-stretch pt-3">
                            <span class="history-dot" aria-hidden="true"></span>
                            <span class="history-line" aria-hidden="true"></span>
                        </div>
                        {{-- 事件說明 --}}
                        <div class="min-w-0 flex-1 pt-2 pb-9">
                            <p class="text-cb2 text-gray5 md:text-lg md:leading-8">{{ $item['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
